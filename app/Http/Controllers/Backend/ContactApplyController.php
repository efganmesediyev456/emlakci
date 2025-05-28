<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CitiesDataTable;
use App\DataTables\ContactApplyDatatable;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\ContactApply;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Backend\CitySaveRequest;

class ContactApplyController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->mainService->model = City::class;
    }

    public function index(ContactApplyDatatable $dataTable)
    {
        return $dataTable->render('backend.pages.contact_applies.index');
    }

    public function delete(ContactApply $item){
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