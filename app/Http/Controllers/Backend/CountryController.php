<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CountriesDataTable;
use App\Helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Backend\CountrySaveRequest;

class CountryController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->mainService->model = Country::class;
    }

    public function index(CountriesDataTable $dataTable)
    {
        return $dataTable->render('backend.pages.countries.index');
    }

    public function create()
    {
        return view('backend.pages.countries.create');
    }

    public function store(CountrySaveRequest $request)
    {
        try {
            $item = new Country();
            DB::beginTransaction();
            $data = $request->except('_token', '_method');

            if ($request->hasFile('icon')) {
                $data['icon'] = FileUploadHelper::uploadFile($request->file('icon'), "countries", 'countries_' . uniqid());
            }

            $item = $this->mainService->save($item, $data);
            $this->mainService->createTranslations($item, $request);
            DB::commit();
            return $this->responseMessage('success', 'Uğurla yaradıldı', [], 200, route('admin.countries.index'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }

    public function edit(Country $item)
    {
        return view('backend.pages.countries.edit', compact('item'));
    }

    public function update(CountrySaveRequest $request, Country $item)
    {
        try {
            DB::beginTransaction();
            $data = $request->except('_token', '_method');
            if ($request->hasFile('icon')) {
                $data['icon'] = FileUploadHelper::uploadFile($request->file('icon'), "countries", 'countries_' . uniqid());
            }
            $item = $this->mainService->save($item, $data);
            $this->mainService->createTranslations($item, $request);
            DB::commit();
            return $this->responseMessage('success', 'Uğurla dəyişdirildi', [], 200, route('admin.countries.index'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }

    public function delete(Country $item)
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

    public function footerStatusChange(Request $request){
         try {
            $model = app($request->model);
            $model = $model::findOrFail($request->id);
            $model->footer_show = $request->status;
            $model->save();

            return response()->json([
                'success' => true,
                'message' => 'Footerdə göstər uğurla yeniləndi!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Xəta baş verdi: ' . $e->getMessage()
            ], 500);
        }
    }
}