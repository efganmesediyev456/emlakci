<?php

namespace App\Http\Controllers\Backend\Regulations;

use App\DataTables\BannerDetailsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\FileUploadHelper;
use App\Models\BannerDetail;

class BannerDetailController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->mainService->model = BannerDetail::class;
    }

    public function index()
    {
        $item = BannerDetail::first();
        if(is_null($item)){
            $item = BannerDetail::create([
            ]);
        }
        return view('backend.pages.banner_details.index', compact('item'));
    }

    public function update(Request $request, BannerDetail $item){
        try {
            DB::beginTransaction();
            $data = $request->except('_token','_method');
            
            if ($request->hasFile('image1')) {
                if ($item->image1) {
                    FileUploadHelper::deleteFile($item->image1);
                }
                $data['image1'] = FileUploadHelper::uploadFile($request->file('image1'), 'banner_details', 'banner_'.uniqid() );
            }

            if ($request->hasFile('image2')) {
                if ($item->image2) {
                    FileUploadHelper::deleteFile($item->image2);
                }
                $data['image2'] = FileUploadHelper::uploadFile($request->file('image2'), 'banner_details', 'banner_'.uniqid() );
            }
            
            $item = $this->mainService->save($item, $data);
            // $this->mainService->createTranslations($item, $request);
            DB::commit();
            return $this->responseMessage('success', 'Uğurla dəyişdirildi', [], 200, route('admin.banner_details.index'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }

    public function delete(BannerDetail $item){
        try {
            DB::beginTransaction();
            
            // Delete icon if exists
            if ($item->icon) {
                FileUploadHelper::deleteFile($item->icon);
            }
            
            $item->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Uğurla silindi');
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }
}