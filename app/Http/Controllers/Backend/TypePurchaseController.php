<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\TypePurchasesDataTable;
use App\Http\Controllers\Controller;
use App\Models\TypePurchase;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Backend\TypePurchaseSaveRequest;
use App\Helpers\FileUploadHelper;


class TypePurchaseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->mainService->model = TypePurchase::class;
    }

    public function index(TypePurchasesDataTable $dataTable)
    {
        return $dataTable->render('backend.pages.type-purchases.index');
    }

    public function create()
    {
        return view('backend.pages.type-purchases.create');
    }

    public function store(TypePurchaseSaveRequest $request)
    {
        try {
            $item = new TypePurchase();
            DB::beginTransaction();
            $data = $request->except('_token', '_method');
            if ($request->hasFile('icon')) {
                $data['icon'] = FileUploadHelper::uploadFile($request->file('icon'), "type_estates", 'type_estates_' . uniqid());
            }
            $item = $this->mainService->save($item, $data);
            $this->mainService->createTranslations($item, $request);
            DB::commit();
            return $this->responseMessage('success', 'Uğurla yaradıldı', [], 200, route('admin.type-purchases.index'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }

    public function edit(TypePurchase $item)
    {
        return view('backend.pages.type-purchases.edit', compact('item'));
    }

    public function update(TypePurchaseSaveRequest $request, TypePurchase $item)
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
            return $this->responseMessage('success', 'Uğurla dəyişdirildi', [], 200, route('admin.type-purchases.index'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }

    public function delete(TypePurchase $item)
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