@extends('backend.layouts.layout')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4>Haqqımda</h4>
            </div>
        </div>
        <div class="card-body">
            <form action="{{route('admin.about.update', $item->id)}}" method="POST" id="saveForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                    @foreach($languages as $language)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if($loop->iteration==1) active @endif" id="{{$language->code}}-tab" 
                            data-bs-toggle="tab" data-bs-target="#{{$language->code}}" type="button"
                            role="tab" aria-controls="{{$language->code}}" aria-selected="true">{{$language->title}}
                        </button>
                    </li>
                    @endforeach
                </ul>

                <div class="tab-content mt-3" id="languageTabsContent">
                    @foreach($languages as $language)
                    <div class="tab-pane fade show @if($loop->iteration==1) active @endif" id="{{$language->code}}"
                        role="tabpanel" aria-labelledby="{{$language->code}}-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title_{{$language->code}}" class="form-label">Başlıq {{$language->code}}</label>
                                    <input type="text" class="form-control" name="title[{{$language->code}}]"
                                        id="title_{{$language->code}}"
                                        placeholder="Başlıq daxil edin"
                                        value="{{$item->getTranslation($language->code)?->title}}">
                                </div>
                            </div>


                             <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="indicator_title1{{$language->code}}" class="form-label">Statistika Başlıq {{$language->code}}</label>
                                    <input type="text" class="form-control" name="indicator_title1[{{$language->code}}]"
                                        id="indicator_title1{{$language->code}}"
                                        placeholder="Başlıq daxil edin"
                                        value="{{$item->getTranslation($language->code)?->indicator_title1}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="indicator_title2{{$language->code}}" class="form-label">Göstəricilərimiz Başlıq {{$language->code}}</label>
                                    <input type="text" class="form-control" name="indicator_title2[{{$language->code}}]"
                                        id="indicator_title2{{$language->code}}"
                                        placeholder="Başlıq daxil edin"
                                        value="{{$item->getTranslation($language->code)?->indicator_title2}}">
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="indicator_title2{{$language->code}}" class="form-label">Göstəricilərimiz Kontent {{$language->code}}</label>
                                    <textarea type="text" class="form-control" name="indicator_description[{{$language->code}}]"
                                        id="indicator_title2{{$language->code}}"
                                        placeholder="Başlıq daxil edin">{{$item->getTranslation($language->code)?->indicator_description}}</textarea>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="choose_why_title{{$language->code}}" class="form-label">Niyə bizi seçməlisiniz? Sual {{$language->code}}</label>
                                    <input type="text" class="form-control" name="choose_why_title[{{$language->code}}]"
                                        id="choose_why_title{{$language->code}}"
                                        placeholder="Başlıq daxil edin"
                                        value="{{$item->getTranslation($language->code)?->choose_why_title}}">
                                </div>
                            </div>


                           <div class="col-md-6">
                             <div class="mb-3">
                                <label for="choose_why_desc{{$language->code}}" class="form-label">Niyə bizi seçməlisiniz? Kontent {{$language->code}}</label>
                                <textarea class="form-control" name="choose_why_desc[{{$language->code}}]"
                                    id="choose_why_desc{{$language->code}}"
                                    placeholder="Haqqında daxil edin">{{$item->getTranslation($language->code)?->choose_why_desc}}</textarea>
                            </div>
                           </div>


                        </div>

                        

                        <div class="mb-3">
                            <label for="description_{{$language->code}}" class="form-label">Haqqında {{$language->code}}</label>
                            <textarea class="form-control ckeditor" name="description[{{$language->code}}]"
                                id="description_{{$language->code}}"
                                placeholder="Haqqında daxil edin">{{$item->getTranslation($language->code)?->description}}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="seo_description_{{$language->code}}" class="form-label">Seo Haqqında {{$language->code}}</label>
                            <textarea class="form-control" name="seo_description[{{$language->code}}]"
                                id="seo_description_{{$language->code}}"
                                placeholder="Seo haqqında daxil edin">{{$item->getTranslation($language->code)?->seo_description}}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="seo_keywords_{{$language->code}}" class="form-label">Açar sözlər {{$language->code}}</label>
                            <input type="text" class="form-control tagsview" name="seo_keywords[{{$language->code}}]"
                                id="seo_keywords_{{$language->code}}"
                                placeholder="Açar sözlər daxil edin"
                                value="{{$item->getTranslation($language->code)?->seo_keywords}}">
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Şəkil</label>
                                    <input type="file" name="image" class="form-control">
                                    @if($item->image)
                                        <img width="300" src="/storage/{{$item->image}}" alt="" class="mt-2">
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
                                    <label for="image" class="form-label">Şəkil3</label>
                                    <input type="file" name="image3" class="form-control">
                                    @if($item->image2)
                                        <img width="300" src="/storage/{{$item->image3}}" alt="" class="mt-2">
                                    @endif
                                </div>
                            </div>

                             <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Xarici elan sayı</label>
                                    <input type="number" name="foreign_advertisements_count" class="form-control" value="{{ $item->foreign_advertisements_count }}">
                                </div>
                            </div>

                             <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Yerli elan sayı</label>
                                    <input type="number" name="local_advertisements_count" class="form-control" value="{{ $item->local_advertisements_count }}">
                                </div>
                            </div>




                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label">İlik fəaliyyət</label>
                                    <input type="number" name="yearly_activity" class="form-control" value="{{ $item->yearly_activity }}">
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