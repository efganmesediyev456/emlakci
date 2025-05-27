<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CriticalReadingsDataTable;
use App\Http\Controllers\Controller;
use App\Models\CriticalReading;
use App\Models\CriticalReadingFile;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\FileUploadHelper;
use App\Http\Requests\Backend\CriticalReadingSaveRequest;
use Storage;

class CriticalReadingController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->mainService->model = CriticalReading::class;
    }

    public function index(Subcategory $subcategories, CriticalReadingsDataTable $dataTable)
    {
        return $dataTable->with('subcategory', $subcategories)->render('backend.pages.critical-readings.index', compact('subcategories'));
    }

    public function create(Subcategory $subcategories)
    {
        return view('backend.pages.critical-readings.create', compact('subcategories'));
    }

    public function store(CriticalReadingSaveRequest $request, Subcategory $subcategories)
    {
        try {
            $item = new CriticalReading();
            DB::beginTransaction();
            $data = $request->except('_token', '_method');
            $data['subcategory_id'] = $subcategories->id;

            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = FileUploadHelper::uploadFile($request->file('thumbnail'), "critical-readings", 'video_thumbnail_' . uniqid());
            }

            if ($request->hasFile('video_url')) {
                $data['video_url'] = FileUploadHelper::uploadFile($request->file('video_url'), "critical-readings", 'video_' . uniqid());
            }

            $item = $this->mainService->save($item, $data);
            if ($request->file('files')) {
                foreach ($request->file('files') as $i => $file_url) {
                    $path = FileUploadHelper::uploadFile($file_url, "interview-preparations", 'file_' . uniqid());
                    $file = $item->files()->create([
                        'file_url' => $path
                    ]);

                    foreach ($request->file_titles as $locale => $titles) {
                        if (isset($titles[$i]) && !empty($titles[$i])) {
                            $file->translations()->create([
                                'locale' => $locale,
                                'title' => $titles[$i]
                            ]);
                        }
                    }
                }
            }
            $this->mainService->createTranslations($item, $request);

            DB::commit();
            return $this->responseMessage('success', 'Uğurla yaradıldı', [], 200, route('admin.subcategories.critical-readings.index', $subcategories->id));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }

    public function edit(Subcategory $subcategories, CriticalReading $item)
    {
        $files = $item->files;
        return view('backend.pages.critical-readings.edit', compact('subcategories', 'item', 'files'));
    }

    public function update(CriticalReadingSaveRequest $request, Subcategory $subcategories, CriticalReading $item)
    {
        try {
            DB::beginTransaction();
            $data = $request->except('_token', '_method');
            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = FileUploadHelper::uploadFile($request->file('thumbnail'), "critical-readings", 'video_thumbnail_' . uniqid());
            }

            if ($request->hasFile('video_url')) {
                $data['video_url'] = FileUploadHelper::uploadFile($request->file('video_url'), "critical-readings", 'video_' . uniqid());
            }

            $item = $this->mainService->save($item, $data);

            // 1. Handle updates to existing files
            if (isset($request->file_ids) && count($request->file_ids) > 0) {
                foreach ($request->file_ids as $index => $fileId) {
                    $interviewFile = CriticalReadingFile::findOrFail($fileId);

                    // Update file if new one is uploaded
                    if ($request->hasFile('update_files') && isset($request->update_files[$index]) && $request->update_files[$index]) {
                        // Delete old file
                        if (Storage::exists('public/' . $interviewFile->file_url)) {
                            Storage::delete('public/' . $interviewFile->file_url);
                        }

                        // Upload new file
                        $file = $request->file('update_files')[$index];
                        $filePath = FileUploadHelper::uploadFile(
                            $file,
                            "interview-files",
                            'file_' . uniqid()
                        );

                        // Update file record
                        $interviewFile->file_url = $filePath;
                        $interviewFile->save();
                    }

                    // Update translations
                    if (isset($request->file_titles)) {
                        foreach ($request->file_titles as $locale => $titles) {
                            if (isset($titles[$index])) {
                                $translation = $interviewFile->translations()
                                    ->where('locale', $locale)
                                    ->first();

                                if ($translation) {
                                    $translation->title = $titles[$index];
                                    $translation->save();
                                } else {
                                    $interviewFile->translations()->create([
                                        'locale' => $locale,
                                        'title' => $titles[$index],
                                    ]);
                                }
                            }
                        }
                    }
                }
            }

            // 2. Add new files
            if ($request->hasFile('new_files')) {
                foreach ($request->file('new_files') as $index => $file) {
                    // Upload the file
                    $filePath = FileUploadHelper::uploadFile(
                        $file,
                        "interview-files",
                        'file_' . uniqid()
                    );

                    // Create file record
                    $interviewFile = new CriticalReadingFile();
                    $interviewFile->critical_reading_id = $item->id;
                    $interviewFile->file_url = $filePath;
                    $interviewFile->save();

                    // Save translations for each file
                    if (isset($request->new_file_titles)) {
                        foreach ($request->new_file_titles as $locale => $titles) {
                            if (isset($titles[$index]) && !empty($titles[$index])) {
                                $interviewFile->translations()->create([
                                    'locale' => $locale,
                                    'title' => $titles[$index]
                                ]);
                            }
                        }
                    }
                }
            }

            // 3. Delete files marked for deletion
            if (isset($request->deleted_files) && count($request->deleted_files) > 0) {
                foreach ($request->deleted_files as $fileId) {
                    $fileToDelete = CriticalReadingFile::find($fileId);

                    if ($fileToDelete) {
                        // Delete file from storage
                        if (Storage::exists('public/' . $fileToDelete->file_url)) {
                            Storage::delete('public/' . $fileToDelete->file_url);
                        }

                        // Delete translations
                        $fileToDelete->translations()->delete();

                        // Delete file record
                        $fileToDelete->delete();
                    }
                }
            }


            $this->mainService->createTranslations($item, $request);

            DB::commit();
            return $this->responseMessage('success', 'Uğurla dəyişdirildi', [], 200, route('admin.subcategories.critical-readings.index', $subcategories->id));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }

    public function destroy(Subcategory $subcategories, CriticalReading $item)
    {
        try {
            DB::beginTransaction();
            $item->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Uğurla silindi');
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }
}