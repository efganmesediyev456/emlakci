<?php

namespace App\Http\Controllers\Api;

use App\Helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdvertisementResource;
use App\Models\Advertisement;
use App\Models\PurchaseForm;
use App\Models\RentForm;
use App\Models\SaleForm;
use Illuminate\Http\Request;
use DB;

class ApplyController extends Controller
{
    public function purchase(Request $request)
    {
        $this->validate($request, [
            "name" => "required",
            "phone" => "required",
            "email" => "required",
            "type_estate_id" => "required|exists:type_estates,id",
            "type_purchase_id" => "required|exists:type_purchases,id",
            "country_id" => "required|exists:countries,id",
            "city_id" => "required|exists:cities,id",
            "rooms" => "required",
            "floors" => "required",
            "price" => "required",
            "min_area" => "required",
            "max_area" => "required",
            "notes" => "nullable"
        ]);
        try {
            DB::beginTransaction();
            $item = PurchaseForm::create($request->except('_token'));
            DB::commit();
            return $this->responseMessage('success', 'Uğurlu əməliyyat ', $item, 200, null);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseMessage('error', 'System xətası ' . $e->getMessage(), null, 500, null);
        }
    }

    public function sale(Request $request)
    {
        $this->validate($request, [
            "name" => "required",
            "phone" => "required",
            "email" => "required",
            "type_estate_id" => "required|exists:type_estates,id",
            "country_id" => "required|exists:countries,id",
            "city_id" => "required|exists:cities,id",
            "rooms" => "required",
            "floors" => "required",
            "price" => "required",
            "min_area" => "required",
            "max_area" => "required",
            "notes" => "nullable",
            "files" => "required|array|min:1"
        ]);

        try {
            DB::beginTransaction();
            $item = SaleForm::create($request->except('_token', 'files'));
            if ($request->hasFile("files") and $request->has("files")) {
                foreach ($request->file('files') as $file) {
                    $file = FileUploadHelper::uploadFile($file, "sale_form_files", 'sale_form_' . uniqid());
                    $item->files()->create([
                        "file_path" => $file
                    ]);
                }
            }
            DB::commit();
            return $this->responseMessage('success', 'Uğurlu əməliyyat ', $item->load('files'), 200, null);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseMessage('error', 'System xətası ' . $e->getMessage(), null, 500, null);
        }
    }

    public function rent(Request $request)
    {
        $this->validate($request, [
            "name" => "required",
            "phone" => "required",
            "email" => "required",
            "type_estate_id" => "required|exists:type_estates,id",
            "country_id" => "required|exists:countries,id",
            "city_id" => "required|exists:cities,id",
            "rooms" => "required",
            "floors" => "required",
            "price" => "required",
            "min_area" => "required",
            "max_area" => "required",
            "notes" => "nullable",
            "files" => "required|array|min:1"
        ]);
        try {
            DB::beginTransaction();
            $item = RentForm::create($request->except('_token', 'files'));
            if ($request->hasFile("files") and $request->has("files")) {
                foreach ($request->file('files') as $file) {
                    $file = FileUploadHelper::uploadFile($file, "rent_form_files", 'rent_form_' . uniqid());
                    $item->files()->create([
                        "file_path" => $file
                    ]);
                }
            }
            DB::commit();
            return $this->responseMessage('success', 'Uğurlu əməliyyat ', $item->load('files'), 200, null);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseMessage('error', 'System xətası ' . $e->getMessage(), null, 500, null);
        }
    }
}
