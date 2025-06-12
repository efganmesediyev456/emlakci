<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\WeOnTheMediaDataTable;
use App\Http\Controllers\Controller;
use App\Models\WeOnTheMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\FileUploadHelper;
use App\Http\Requests\Backend\WeOnTheMediaSaveRequest;

class WeOnTheMediaController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->mainService->model = WeOnTheMedia::class;
    }

    public function index(WeOnTheMediaDataTable $dataTable)
    {
        return $dataTable->render('backend.pages.we_on_the_media.index');
    }

    public function create()
    {
        return view('backend.pages.we_on_the_media.create');
    }

    public function store(WeOnTheMediaSaveRequest $request)
    {
        try {
            $item = new WeOnTheMedia();
            DB::beginTransaction();
            $data = $request->except('_token', '_method');
            
            if ($request->hasFile('image')) {
                $data['image'] = FileUploadHelper::uploadFile($request->file('image'), "we_on_the_media", 'we_on_the_media_' . uniqid());
            }
            
            $item = $this->mainService->save($item, $data);
            $this->mainService->createTranslations($item, $request);
            
            DB::commit();
            return $this->responseMessage('success', 'Uğurla yaradıldı', [], 200, route('admin.we_on_the_media.index'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }

    public function edit(WeOnTheMedia $item)
    {
        return view('backend.pages.we_on_the_media.edit', compact('item'));
    }

    public function update(WeOnTheMediaSaveRequest $request, WeOnTheMedia $item)
    {
        try {
            DB::beginTransaction();
            $data = $request->except('_token', '_method');
            
            if ($request->hasFile('image')) {
                $data['image'] = FileUploadHelper::uploadFile($request->file('image'), "we_on_the_media", 'we_on_the_media_' . uniqid());
            }
            
            $item = $this->mainService->save($item, $data);
            $this->mainService->createTranslations($item, $request);

            DB::commit();
            return $this->responseMessage('success', 'Uğurla dəyişdirildi', [], 200, route('admin.we_on_the_media.index'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }

    public function delete(WeOnTheMedia $item)
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