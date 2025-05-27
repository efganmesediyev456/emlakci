<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CitiesDataTable;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Backend\CitySaveRequest;

class CityController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->mainService->model = City::class;
    }

    public function index(CitiesDataTable $dataTable)
    {
        return $dataTable->render('backend.pages.cities.index');
    }

    public function create()
    {
        $countries = Country::where('status', true)->get();
        return view('backend.pages.cities.create', compact('countries'));
    }

    public function store(CitySaveRequest $request)
    {
        try {
            $item = new City();
            DB::beginTransaction();
            $data = $request->except('_token', '_method');
            $item = $this->mainService->save($item, $data);
            $this->mainService->createTranslations($item, $request);
            DB::commit();
            return $this->responseMessage('success', 'Uğurla yaradıldı', [], 200, route('admin.cities.index'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }

    public function edit(City $item)
    {
        $countries = Country::where('status', true)->get();
        return view('backend.pages.cities.edit', compact('item', 'countries'));
    }

    public function update(CitySaveRequest $request, City $item)
    {
        try {
            DB::beginTransaction();
            $data = $request->except('_token', '_method');
            $item = $this->mainService->save($item, $data);
            $this->mainService->createTranslations($item, $request);
            DB::commit();
            return $this->responseMessage('success', 'Uğurla dəyişdirildi', [], 200, route('admin.cities.index'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }

    public function delete(City $item)
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