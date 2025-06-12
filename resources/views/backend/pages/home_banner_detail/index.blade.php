@extends('backend.layouts.layout')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4>Home Banner Detalları</h4>
            </div>
        </div>
        <div class="card-body">

            <form action="{{route('admin.home_banner_detail.update',['item'=> $item->id])}}" method="POST" id="saveForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="image1" class="form-label">Şəkil 1</label>
                            <input type="file" name="image1" class="form-control">
                            @if($item->image1)
                            <img width="300" src="/storage/{{$item->image1}}" alt="" class="mt-2">
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="image2" class="form-label">Şəkil 2</label>
                            <input type="file" name="image2" class="form-control">
                            @if($item->image2)
                            <img width="300" src="/storage/{{$item->image2}}" alt="" class="mt-2">
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="first_payed" class="form-label">ilkin ödəniş</label>
                            <input type="number" class="form-control" name="first_payed"
                                id="first_payed" value="{{ $item->first_payed }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="inside_credit" class="form-label">Daxili kredit</label>
                            <input type="number" class="form-control" name="inside_credit"
                                id="inside_credit" value="{{ $item->inside_credit }}">
                        </div>
                    </div>

                     <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone" class="form-label">Telefon</label>
                            <input type="text" class="form-control" name="phone"
                                id="phone" value="{{ $item->phone }}">
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="d-flex justify-content-end">
                        <div class="form-group">
                            <button type="submit" class="form-control btn btn-success">
                                <i class="fas fa-save"></i>
                                <span>Yadda saxla</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection