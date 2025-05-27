<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\AdvantagesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Advantage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\FileUploadHelper;
use App\Http\Requests\Backend\AdvantageSaveRequest;

class AdvantageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->mainService->model = Advantage::class;
    }

    public function index(AdvantagesDataTable $dataTable)
    {
        return $dataTable->render('backend.pages.advantages.index');
    }

    public function create()
    {
        return view('backend.pages.advantages.create');
    }

    public function store(AdvantageSaveRequest $request)
    {
        try {
            $item = new Advantage();
            DB::beginTransaction();
            $data = $request->except('_token', '_method');
            if ($request->hasFile('icon')) {
                $data['icon'] = FileUploadHelper::uploadFile($request->file('icon'), "advantages", 'advantage_' . uniqid());
            }
            $item = $this->mainService->save($item, $data);
            $this->mainService->createTranslations($item, $request);
            DB::commit();
            return $this->responseMessage('success', 'Uğurla yaradıldı', [], 200, route('admin.advantages.index'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }

    public function edit(Advantage $item)
    {
        return view('backend.pages.advantages.edit', compact('item'));
    }

    public function update(AdvantageSaveRequest $request, Advantage $item)
    {
        try {
            DB::beginTransaction();
            $data = $request->except('_token', '_method');
            if ($request->hasFile('icon')) {
                $data['icon'] = FileUploadHelper::uploadFile($request->file('icon'), "advantages", 'advantage_' . uniqid());
            }
            $item = $this->mainService->save($item, $data);
            $this->mainService->createTranslations($item, $request);

            DB::commit();
            return $this->responseMessage('success', 'Uğurla dəyişdirildi', [], 200, route('admin.advantages.index'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }

    public function delete(Advantage $item)
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