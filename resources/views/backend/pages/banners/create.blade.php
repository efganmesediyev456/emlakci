@extends('backend.layouts.layout')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4>Bannerlər</h4>
                <div class="buttons">
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-success">Geriyə qayıt</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.banners.store') }}" method="POST" id="saveForm" enctype="multipart/form-data">
                @csrf
                
                <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                    @foreach($languages as $language)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if($loop->first) active @endif"
                            id="{{$language->code}}-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#{{$language->code}}"
                            type="button" role="tab"
                            aria-controls="{{$language->code}}"
                            aria-selected="true">
                            {{$language->title}}
                        </button>
                    </li>
                    @endforeach
                </ul>
                
                <div class="tab-content mt-3" id="languageTabsContent">
                    @foreach($languages as $language)
                    <div class="tab-pane fade show @if($loop->first) active @endif"
                        id="{{$language->code}}" role="tabpanel"
                        aria-labelledby="{{$language->code}}-tab">
                        
                        <div class="mb-3">
                            <label for="title_{{$language->code}}" class="form-label">Başlıq ({{$language->code}})</label>
                            <input type="text" class="form-control"
                                name="title[{{$language->code}}]"
                                id="title_{{$language->code}}"
                                placeholder="Başlıq daxil edin">
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mb-3 mt-3">
                    <label for="image" class="form-label">Banner şəkli</label>
                    <input type="file" class="form-control" name="image" id="image" required>
                    <small class="text-muted">Tövsiyə olunan ölçü: 1920x600 piksel</small>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="order" class="form-label">Sıralama</label>
                            <input type="number" class="form-control" name="order" id="order" value="0" min="0">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" name="status" id="status">
                                <option value="1" selected>Aktiv</option>
                                <option value="0">Deaktiv</option>
                            </select>
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