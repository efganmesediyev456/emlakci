<?php
namespace App\Http\Controllers\Backend;

use App\Helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use App\Models\EventBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventBannerController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->mainService->model = EventBanner::class;
    }

    public function index()
    {
        $item = EventBanner::first();
        if(is_null($item)){
            $item =  new EventBanner([

            ]);
            $item->save();
        }

        return view('backend.pages.event_banner.index', compact('item'));
    }

    public function update(Request $request, EventBanner $item)
    {
        try {
            DB::beginTransaction();
            $data = $request->except('_token','_method');

            if ($request->hasFile('image')) {
                $data['image'] = FileUploadHelper::uploadFile($request->file('image'), "event_banner", 'event_banner_' . uniqid());
            }
            
            $data['url'] = $request->url;

            $item = $this->mainService->save($item, $data);
            $this->mainService->createTranslations($item,$request);
            DB::commit();
            return $this->responseMessage('success', 'Uğurla dəyişdirildi',[], 200,route('admin.event_banner.index'));
        }catch (\Exception $exception){
            DB::rollBack();
            return $this->responseMessage('error',$exception->getMessage(), [], 500);
        }
    }
}