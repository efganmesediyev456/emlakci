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

        return $typePurchases;
       
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

        return $typeEstates;
       
    }

}
