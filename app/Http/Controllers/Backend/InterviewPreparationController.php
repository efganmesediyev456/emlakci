<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\InterviewPreparationsDataTable;
use App\Http\Controllers\Controller;
use App\Models\InterviewPreparation;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\FileUploadHelper;
use App\Http\Requests\Backend\InterviewPreparationSaveRequest;
use App\Models\InterviewPreparationFile;
use Illuminate\Support\Facades\Storage;

class InterviewPreparationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->mainService->model = InterviewPreparation::class;
    }

    public function index(Subcategory $subcategories, InterviewPreparationsDataTable $dataTable)
    {
        return $dataTable->with('subcategory', $subcategories)->render('backend.pages.interview-preparations.index', compact('subcategories'));
    }

    public function create(Subcategory $subcategories)
    {
        return view('backend.pages.interview-preparations.create', compact('subcategories'));
    }

    public function store(InterviewPreparationSaveRequest $request, Subcategory $subcategories)
    {
        try {
            $item = new InterviewPreparation();
            DB::beginTransaction();
            $data = $request->except('_token', '_method');
            $data['subcategory_id'] = $subcategories->id;
            unset($data['default_locale']);
            
            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = FileUploadHelper::uploadFile($request->file('thumbnail'), "interview-preparations", 'video_thumbnail_' . uniqid());
            }
            
            if ($request->hasFile('video_url')) {
                $data['video_url'] = FileUploadHelper::uploadFile($request->file('video_url'), "interview-preparations", 'video_' . uniqid());
            }

            // dd($request->all());
            
            
            $item = $this->mainService->save($item, $data);
            if ($request->file('files')) {
                foreach($request->file('files') as $i=>$file_url){
                    $path=FileUploadHelper::uploadFile($file_url, "interview-preparations", 'file_' . uniqid());
                    $file = $item->files()->create([
                        'file_url'=>$path
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
            return $this->responseMessage('success', 'Uğurla yaradıldı', [], 200, route('admin.subcategories.interview-preparations.index', $subcategories->id));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }

    public function edit(Subcategory $subcategories, InterviewPreparation $item)
    {
        $files = $item->files;
        return view('backend.pages.interview-preparations.edit', compact('subcategories', 'item', 'files'));
    }

    public function update(InterviewPreparationSaveRequest $request, Subcategory $subcategories, InterviewPreparation $item)
    {
        try {
            DB::beginTransaction();
            $data = $request->except('_token', '_method');
            unset($data['default_locale']);
            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = FileUploadHelper::uploadFile($request->file('thumbnail'), "interview-preparations", 'video_thumbnail_' . uniqid());
            }

            if ($request->hasFile('video_url')) {
                $data['video_url'] = FileUploadHelper::uploadFile($request->file('video_url'), "interview-preparations", 'video_' . uniqid());
            }

            
            
            $item = $this->mainService->save($item, $data);







            // 1. Handle updates to existing files
            if (isset($request->file_ids) && count($request->file_ids) > 0) {
                foreach ($request->file_ids as $index => $fileId) {
                    $interviewFile = InterviewPreparationFile::findOrFail($fileId);
                    
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
                    $interviewFile = new InterviewPreparationFile();
                    $interviewFile->interview_preparation_id = $item->id;
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
                    $fileToDelete = InterviewPreparationFile::find($fileId);
                    
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
            return $this->responseMessage('success', 'Uğurla dəyişdirildi', [], 200, route('admin.subcategories.interview-preparations.index', $subcategories->id));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }

    public function destroy(Subcategory $subcategories, InterviewPreparation $item)
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