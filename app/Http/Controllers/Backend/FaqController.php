<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\FaqsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\FileUploadHelper;
use App\Http\Requests\Backend\FaqSaveRequest;

class FaqController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->mainService->model = Faq::class;
    }

    public function index(FaqsDataTable $dataTable)
    {
        return $dataTable->render('backend.pages.faqs.index');
    }

    public function create()
    {
        return view('backend.pages.faqs.create');
    }

    public function store(FaqSaveRequest $request)
    {
        try {
            $item = new Faq();
            DB::beginTransaction();
            $data = $request->except('_token', '_method');
            $item = $this->mainService->save($item, $data);
            $this->mainService->createTranslations($item, $request);
            DB::commit();
            return $this->responseMessage('success', 'Uğurla yaradıldı', [], 200, route('admin.faqs.index'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }

    public function edit(Faq $item)
    {
        return view('backend.pages.faqs.edit', compact('item'));
    }

    public function update(FaqSaveRequest $request, Faq $item)
    {
        try {
            DB::beginTransaction();
            $data = $request->except('_token', '_method');
            $item = $this->mainService->save($item, $data);
            $this->mainService->createTranslations($item, $request);
            DB::commit();
            return $this->responseMessage('success', 'Uğurla dəyişdirildi', [], 200, route('admin.faqs.index'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }

    public function delete(Faq $item)
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