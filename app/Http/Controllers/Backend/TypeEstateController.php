<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\TypeEstatesDataTable;
use App\Http\Controllers\Controller;
use App\Models\TypeEstate;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Backend\TypeEstateSaveRequest;
use App\Helpers\FileUploadHelper;


class TypeEstateController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->mainService->model = TypeEstate::class;
    }

    public function index(TypeEstatesDataTable $dataTable)
    {
        return $dataTable->render('backend.pages.type-estates.index');
    }

    public function create()
    {
        return view('backend.pages.type-estates.create');
    }

    public function store(TypeEstateSaveRequest $request)
    {
        try {
            $item = new TypeEstate();
            DB::beginTransaction();
            $data = $request->except('_token', '_method');

            if ($request->hasFile('icon')) {
                $data['icon'] = FileUploadHelper::uploadFile($request->file('icon'), "type_estates", 'type_estates_' . uniqid());
            }

            $item = $this->mainService->save($item, $data);
            $this->mainService->createTranslations($item, $request);
            DB::commit();
            return $this->responseMessage('success', 'Uğurla yaradıldı', [], 200, route('admin.type-estates.index'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }

    public function edit(TypeEstate $item)
    {
        return view('backend.pages.type-estates.edit', compact('item'));
    }

    public function update(TypeEstateSaveRequest $request, TypeEstate $item)
    {
        try {
            DB::beginTransaction();
            $data = $request->except('_token', '_method');
            if ($request->hasFile('icon')) {
                $data['icon'] = FileUploadHelper::uploadFile($request->file('icon'), "type_estates", 'type_estates_' . uniqid());
            }
            $item = $this->mainService->save($item, $data);
            $this->mainService->createTranslations($item, $request);
            DB::commit();
            return $this->responseMessage('success', 'Uğurla dəyişdirildi', [], 200, route('admin.type-estates.index'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }

    public function delete(TypeEstate $item)
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