<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ExamsDataTable;
use App\Helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Backend\ExamSaveRequest;

class ExamController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->mainService->model = Exam::class;
    }

    public function index(Subcategory $subcategories, ExamsDataTable $dataTable)
    {
        return $dataTable->with('subcategory', $subcategories)->render('backend.pages.exams.index', compact('subcategories'));
    }

    public function create(Subcategory $subcategories)
    {
        return view('backend.pages.exams.create', compact('subcategories'));
    }

    public function store(ExamSaveRequest $request, Subcategory $subcategories)
    {
        try {
            $item = new Exam();
            DB::beginTransaction();
            $data = $request->except('_token', '_method');
            $data['subcategory_id'] = $subcategories->id;

            if ($request->hasFile('icon')) {
                $data['icon'] = FileUploadHelper::uploadFile($request->file('icon'), "exams", 'exams_' . uniqid());
            }
            
            $item = $this->mainService->save($item, $data);
            $this->mainService->createTranslations($item, $request);

            DB::commit();
            return $this->responseMessage('success', 'Uğurla yaradıldı', [], 200, route('admin.subcategories.exams.index', $subcategories->id));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }

    public function edit(Subcategory $subcategories, Exam $item)
    {
        return view('backend.pages.exams.edit', compact('subcategories', 'item'));
    }

    public function update(ExamSaveRequest $request, Subcategory $subcategories, Exam $item)
    {
        try {
            DB::beginTransaction();
            $data = $request->except('_token', '_method');

            if ($request->hasFile('icon')) {
                $data['icon'] = FileUploadHelper::uploadFile($request->file('icon'), "exams", 'exams_' . uniqid());
            }
            
            $item = $this->mainService->save($item, $data);
            $this->mainService->createTranslations($item, $request);

            DB::commit();
            return $this->responseMessage('success', 'Uğurla dəyişdirildi', [], 200, route('admin.subcategories.exams.index', $subcategories->id));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }

    public function destroy(Subcategory $subcategories, Exam $item)
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