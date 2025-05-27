<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\EstatesDataTable;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\EstateMedia;
use App\Models\Property;
use App\Models\TypeEstate;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Yajra\DataTables\EloquentDataTable;
use App\Helpers\FileUploadHelper;
use App\Http\Requests\Backend\EstateSaveRequest;
use App\Models\Estate;

class EstateController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->mainService->model = Estate::class;
    }

    public function index(EstatesDataTable $dataTable)
    {
        return $dataTable->render('backend.pages.estates.index');
    }

    public function create()
    {
        $type_estates = TypeEstate::get();
        $countries=Country::get();
        $properties = Property::get();
        return view('backend.pages.estates.create', compact('type_estates','countries','properties'));
    }

    public function store(EstateSaveRequest $request)
    {
        try {
            $item = new Estate();
            DB::beginTransaction();
            $data = $request->except('_token', '_method');
            if ($request->hasFile('image')) {
                $data['image'] = FileUploadHelper::uploadFile($request->file('image'), "estates", 'estate_' . uniqid());
            }
            $item = $this->mainService->save($item, $data);
            if ($request->hasFile('media_files')) {
                foreach ($request->file('media_files') as $index => $mediaFile) {
                    $mediaPath = FileUploadHelper::uploadFile($mediaFile, "estates/media", 'media_' . uniqid());
                    EstateMedia::create([
                        'file' => $mediaPath,
                        'status' => 1, 
                        'order' => $index,
                        'estate_id' => $item->id
                    ]);
                }
            }

           

            if($request->properties and count($request->properties)){
                $item->properties()->sync(array_keys($request->properties));
            }

            $this->mainService->createTranslations($item, $request);
            DB::commit();
            return $this->responseMessage('success', 'Uğurla yaradıldı', [], 200, route('admin.estates.index'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }


    public function edit(Estate $item)
    {
        $type_estates = TypeEstate::get();
        $countries=Country::get();
        $cities = $item->country->cities;
        $properties=Property::get();
        return view('backend.pages.estates.edit', compact('item', 'type_estates', 'countries', 'cities', 'properties'));
    }

    public function update(EstateSaveRequest $request, Estate $item)
    {
        try {
            DB::beginTransaction();
            $data = $request->except('_token', '_method');
            if ($request->hasFile('image')) {
                $data['image'] = FileUploadHelper::uploadFile($request->file('image'), "estates", 'estate_' . uniqid());
            }
            $item = $this->mainService->save($item, $data);
            $this->mainService->createTranslations($item, $request);


            if ($request->has('delete_media') && is_array($request->delete_media)) {
                EstateMedia::whereIn('id', $request->delete_media)->delete();
            }
            
            if ($request->has('media_order') && is_array($request->media_order)) {
                foreach ($request->media_order as $mediaId => $order) {
                    EstateMedia::where('id', $mediaId)->update(['order' => $order]);
                }
            }

            
            $item->properties()->sync(array_keys($request->properties ?? []));
            

            if ($request->hasFile('media_files')) {
                $lastOrder = EstateMedia::where('estate_id', $item->id)
                                ->max('order') ?? 0;
                
                foreach ($request->file('media_files') as $index => $mediaFile) {
                    $mediaPath = FileUploadHelper::uploadFile($mediaFile, "estates/media", 'media_' . uniqid());
                    
                    EstateMedia::create([
                        'file' => $mediaPath,
                        'status' => 1, // Default status active
                        'order' => $lastOrder + $index + 1, // Continue ordering after existing files
                        'estate_id' => $item->id
                    ]);
                }
            }

            
            DB::commit();
            return $this->responseMessage('success', 'Uğurla dəyişdirildi', [], 200, route('admin.estates.index'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }


    public function delete(Estate $item)
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


    public function getCities(Request $request){
       
        $country = Country::find($request->country_id);
        $cities=$country?->cities?->prepend(new City([
            'id'=>"",
            "title"=>"Seçin"
        ]));
     
        $cities = $cities?->map(function($item){
            return '<option value="'.$item->id.'">'.$item->title.'</option>';
        })->implode('');

        return response()->json([
            'view'=>$cities
        ]);

    }
}