<?php
namespace App\Http\Controllers\Backend;

use App\Helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use App\Models\HomeBannerDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeBannerDetailController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->mainService->model = HomeBannerDetail::class;
    }

    public function index()
    {
        $item = HomeBannerDetail::first();
        if(is_null($item)){
            $item = new HomeBannerDetail([
            ]);
            $item->save();
        }
        return view('backend.pages.home_banner_detail.index', compact('item'));
    }

   public function update(Request $request, HomeBannerDetail $item)
    {
        try {
            DB::beginTransaction();
            $data = $request->except('_token','_method');

            if ($request->hasFile('image1')) {
                $data['image1'] = FileUploadHelper::uploadFile($request->file('image1'), "home_banner_detail", 'home_banner_detail_' . uniqid());
            }
            if ($request->hasFile('image2')) {
                $data['image2'] = FileUploadHelper::uploadFile($request->file('image2'), "home_banner_detail", 'home_banner_detail_' . uniqid());
            }
            
            $item = $this->mainService->save($item, $data);
            DB::commit();
            return $this->responseMessage('success', 'Uğurla dəyişdirildi',[], 200,route('admin.home_banner_detail.index'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error',$exception->getMessage(), [], 500);
        }
    }
}