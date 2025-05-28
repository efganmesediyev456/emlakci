<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\About\AboutResource;
use App\Http\Resources\AdvantageResource;
use App\Http\Resources\AdvertisementResource;
use App\Http\Resources\BlogAndNewsResource;
use App\Http\Resources\LanguageResource;
use App\Http\Resources\Products\ProductResource;
use App\Http\Resources\Users\UserResource;
use App\Models\About;
use App\Models\Advantage;
use App\Models\Advertisement;
use App\Models\BlogNew;
use App\Models\Language;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdvantageController extends Controller
{
   
    public function index(Request $request){
         try{
            $items = Advantage::status()->order()->get();
            return AdvantageResource::collection($items);
        }catch (\Exception $e) {
            return $this->responseMessage('error', 'System xətası ' . $e->getMessage(), null, 500, null);
        }
    }
}
