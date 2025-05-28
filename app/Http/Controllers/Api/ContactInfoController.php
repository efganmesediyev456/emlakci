<?php

namespace App\Http\Controllers\Api;

use App\Helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\CatalogCollection;
use App\Http\Resources\CatalogResource;
use App\Http\Resources\CountryInfoResource;
use App\Models\Catalog;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ContactInfoController extends Controller
{
    public function index(Request $request)
    {
        $countryInfos = Country::where('footer_show',1)->status()->order()->get();
      
        return CountryInfoResource::collection($countryInfos);
    }
}
