@extends('backend.layouts.layout')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4>Tez-tez verilən sual</h4>
                <div class="buttons">
                    <a href="{{ route('admin.faqs.index') }}" class="btn btn-success">
                        <i class="fas fa-arrow-left"></i>
                        <span class="wmax">Geriyə qayıt</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{route('admin.faqs.update', $item->id)}}" method="POST" id="saveForm" enctype="multipart/form-data">
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
                                <div class="mb-3">
                                    <label for="title_{{$language->code}}" class="form-label">Başlıq ({{$language->code}})</label>
                                    <input type="text" class="form-control"
                                        name="title[{{$language->code}}]"
                                        id="title_{{$language->code}}"
                                        placeholder="Başlıq daxil edin" value="{{ $item->translate($language->code)?->title }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description_{{$language->code}}" class="form-label">Qısa kontent ({{$language->code}})</label>
                                    <textarea class="form-control"
                                        name="description[{{$language->code}}]"
                                        id="description_{{$language->code}}"
                                        rows="5"
                                        placeholder="Qısa kontent daxil edin">{{ $item->translate($language->code)?->description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
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

@push('js')
<script>
    $(document).ready(function() {
        // Initialize CKEditor for description fields
        @foreach($languages as $language)
            ClassicEditor
                .create(document.querySelector('#description_{{$language->code}}'))
                .catch(error => {
                    console.error(error);
                });
        @endforeach
    });
</script>
@endpush