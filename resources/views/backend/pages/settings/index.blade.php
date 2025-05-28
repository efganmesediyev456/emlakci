@extends('backend.layouts.layout')

@section('content')
<style>
    img{
        max-height: 100px;
    }
</style>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Sayt Parametrləri</h4>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update', $item->id) }}" method="POST" id="saveForm"
                    enctype="multipart/form-data">
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="header_logo" class="form-label">Header Logo</label>
                                <input type="file" name="header_logo" class="form-control">
                                <small class="text-muted d-block my-2">Tövsiyə olunan ölçü: 160x50 piksel</small>

                                @if ($item->header_logo)
                                    <img width="300" src="{{ '/storage/' . $item->header_logo }}" alt="Header Logo">
                                @endif
                            </div>
                        </div>
                       
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="footer_logo" class="form-label">Footer Logo</label>
                                <input type="file" name="footer_logo" class="form-control">
                                <small class="text-muted d-block my-2">Tövsiyə olunan ölçü: 160x50 piksel</small>

                                @if ($item->footer_logo)
                                    <img width="300" src="{{ '/storage/' . $item->footer_logo }}" alt="Footer Logo">
                                @endif
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="favicon" class="form-label">Favicon</label>
                                <input type="file" name="favicon" class="form-control">
                                @if ($item->favicon)
                                    <img width="64" src="{{ '/storage/' . $item->favicon }}" alt="Favicon">
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="whatsapp_number" class="form-label">Whatsapp nömrəsi</label>
                                <input type="text" name="whatsapp_number" class="form-control" value="{{ $item->whatsapp_number }}">
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
