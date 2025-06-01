<?php

namespace App\Http\Controllers\Api;

use App\Helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\CatalogCollection;
use App\Http\Resources\CatalogResource;
use App\Http\Resources\GalleryResource;
use App\Models\Catalog;
use App\Models\GalleryPhoto;
use App\Models\GalleryVideo;
use App\Models\TypeEstate;
use App\Models\Country;
use App\Models\TypePurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FilterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function typePurchases(Request $request)
    {
        $typePurchases = TypePurchase::where('status',1)->orderBy('id','desc')->get()->map(function($e){
            return [
                'id'=>$e->id,
                'title'=>$e->title,
                'icon'=>url('storage/'.$e->icon)
            ];
        });
        return $this->responseMessage('success', 'Uğurlu əməliyyat', $typePurchases, 404, null);
    }


    public function typeEstates(Request $request)
    {
        $typeEstates = TypeEstate::where('status',1)->orderBy('id','desc')->get()->map(function($e){
            return [
                'id'=>$e->id,
                'title'=>$e->title,
                'icon'=>url('storage/'.$e->icon)
            ];
        });
        
        return $this->responseMessage('success', 'Uğurlu əməliyyat', $typeEstates, 404, null);
    }

    public function countries(Request $request)
    {
        $countries = Country::where('status',1)->orderBy('id','desc')->get()->map(function($e){
            return [
                'id'=>$e->id,
                'title'=>$e->title,
                'icon'=>url('storage/'.$e->icon)
            ];
        });

         return $this->responseMessage('success', 'Uğurlu əməliyyat', $countries, 404, null);
       
    }


    
     public function cities($item)
    {
         try {
            $country = Country::find($item);
            if(is_null($country)){
                return $this->responseMessage('error', 'Data tapılmadı ', null, 404, null);
            }
            $items = $country->cities;
            $items = $items->map(fn($it)=>
                [
                    "id"=>$it->id,
                    "title"=>$it->title
                ]
            );

            return $this->responseMessage('success', 'Uğurlu əməliyyat', $items, 404, null);

        } catch (\Exception $e) {
            return $this->responseMessage('error', 'System xətası ' . $e->getMessage(), null, 500, null);
        }
    }

}
