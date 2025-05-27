@extends('backend.layouts.layout')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4>Kiçik Video Düzəliş - {{ $subcategories->translate() ? $subcategories->translate()->title : 'N/A' }}</h4>
                <div class="buttons d-flex">
                    <a href="{{ route('admin.subcategories.little-video-rolics.index', $subcategories->id) }}" class="btn btn-success d-flex align-items-center gap-2">
                        <i class="fas fa-arrow-left"></i>
                        <span class="wmax">Geriyə qayıt</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.subcategories.little-video-rolics.update', [$subcategories->id, $item->id]) }}" method="POST" id="saveForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

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

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3 w-100">
                                    <label for="title_{{$language->code}}" class="form-label">Başlıq ({{$language->code}})</label>
                                    <input type="text" class="form-control"
                                        name="title[{{$language->code}}]"
                                        id="title_{{$language->code}}"
                                        placeholder="Başlıq daxil edin"
                                        value="{{ $item->translate($language->code)?->title }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description_{{$language->code}}" class="form-label">Təsvir ({{$language->code}})</label>
                                    <textarea class="form-control ckeditor" name="description[{{$language->code}}]"
                                        id="description_{{$language->code}}"
                                        placeholder="Təsvir daxil edin">{{ $item->translate($language->code)?->description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="video_url" class="form-label">Video</label>
                            <input type="file" class="form-control" name="video_url" id="video_url" 
                                placeholder="Video daxil edin">
                            @if($item->video_url)
                                <a href="{{ url('storage/'.$item->video_url) }}" class="btn btn-success my-1">Fayla bax</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="">Örtük Şəkli</label>
                            <input type="file" name="thumbnail" class="form-control">
                            @if($item->thumbnail)
                                <img width="100" src="/storage/{{$item->thumbnail}}" alt="">
                            @endif
                            <small class="text-muted d-block">Video üçün örtük şəkli yükləyin</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group d-block w-100">
                            <label for="">Tarix</label>
                            <input type="date" class="form-control" name="date" value="{{ $item->date ? $item->date : '' }}"/>
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