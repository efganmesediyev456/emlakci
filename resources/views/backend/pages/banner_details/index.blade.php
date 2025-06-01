@extends('backend.layouts.layout')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4>Banner ətraflı</h4>
            </div>
        </div>
        <div class="card-body">
            <form action="{{route('admin.banner_details.update', $item->id)}}" method="POST" id="saveForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="image" class="form-label">Şəkil1</label>
                            <input type="file" name="image1" class="form-control">
                            @if($item->image1)
                            <img width="300" src="/storage/{{$item->image1}}" alt="" class="mt-2">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="image" class="form-label">Şəkil2</label>
                            <input type="file" name="image2" class="form-control">
                            @if($item->image2)
                            <img width="300" src="/storage/{{$item->image2}}" alt="" class="mt-2">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="image" class="form-label">Ilkin ödəniş</label>
                            <input type="text" name="first_payment" class="form-control" value="{{ $item->first_payment }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="image" class="form-label">Daxili kredit</label>
                            <input type="text" name="inner_credit" class="form-control" value="{{ $item->inner_credit }}">
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