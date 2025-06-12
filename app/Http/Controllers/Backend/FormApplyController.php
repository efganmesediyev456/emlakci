<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\FaqsDataTable;
use App\DataTables\PurchaseFormDatatable;
use App\DataTables\SaleFormDatatable;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\PurchaseForm;
use App\Models\RentForm;
use App\Models\SaleForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\FileUploadHelper;
use App\Http\Requests\Backend\FaqSaveRequest;
use App\DataTables\RentFormDatatable;

class FormApplyController extends Controller
{

    public function purchaseForm(PurchaseFormDatatable $dataTable)
    {
        return $dataTable->render('backend.pages.form-purchases.index');
    }


    public function purchaseFormShow(PurchaseForm $purchaseForm){
        return view('backend.pages.form-purchases.show', ['item'=>$purchaseForm]);
    }

    public function purchaseFormDelete (Request $request,PurchaseForm $purchaseForm){
        $purchaseForm->delete();
        return redirect()->back()->withSuccess('Uğurla silindi');
    }

     public function saleForm(SaleFormDatatable $dataTable)
    {
        return $dataTable->render('backend.pages.sale-forms.index');
    }

     public function saleFormShow (SaleForm $saleForm){
        return view('backend.pages.sale-forms.show', ['item'=>$saleForm]);
    }

    public function saleFormDelete  (Request $request,SaleForm $saleForm){
        $saleForm->delete();
        return redirect()->back()->withSuccess('Uğurla silindi');
    }

    public function rentForm(RentFormDatatable $dataTable)
    {
        return $dataTable->render('backend.pages.rent-forms.index');
    }

    public function rentFormShow (RentForm $rentForm){
        return view('backend.pages.rent-forms.show', ['item'=>$rentForm]);
    }

    public function rentFormDelete  (Request $request,RentForm $rentForm){
        $rentForm->delete();
        return redirect()->back()->withSuccess('Uğurla silindi');
    }
}