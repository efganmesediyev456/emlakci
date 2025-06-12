<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\HomeBannersDataTable;
use App\Http\Controllers\Controller;
use App\Models\HomeBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\FileUploadHelper;
use App\Http\Requests\Backend\HomeBannerSaveRequest;
use App\Models\Country;

class HomeBannerController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->mainService->model = HomeBanner::class;
    }

    public function index(HomeBannersDataTable $dataTable)
    {
        return $dataTable->render('backend.pages.home_banners.index');
    }

    public function create()
    {
        $countries = Country::get();
        return view('backend.pages.home_banners.create', compact('countries'));
    }

    public function store(HomeBannerSaveRequest $request)
    {
        try {
            $item = new HomeBanner();
            DB::beginTransaction();
            $data = $request->except('_token', '_method');
            if ($request->hasFile('image')) {
                $data['image'] = FileUploadHelper::uploadFile($request->file('image'), "home_banners", 'home_banner_' . uniqid());
            }
            $item = $this->mainService->save($item, $data);
            $this->mainService->createTranslations($item, $request);
            DB::commit();
            return $this->responseMessage('success', 'Uğurla yaradıldı', [], 200, route('admin.home_banners.index'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }

    public function edit(HomeBanner $item)
    {
        $countries=Country::get();
        $cities = $item->country?->cities;
        return view('backend.pages.home_banners.edit', compact('item', 'countries', 'cities'));
    }

    public function update(HomeBannerSaveRequest $request, HomeBanner $item)
    {
        try {
            DB::beginTransaction();
            $data = $request->except('_token', '_method');
            if ($request->hasFile('image')) {
                $data['image'] = FileUploadHelper::uploadFile($request->file('image'), "home_banners", 'home_banner_' . uniqid());
            }
            $item = $this->mainService->save($item, $data);
            $this->mainService->createTranslations($item, $request);

            DB::commit();
            return $this->responseMessage('success', 'Uğurla dəyişdirildi', [], 200, route('admin.home_banners.index'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }

    public function delete(HomeBanner $item)
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