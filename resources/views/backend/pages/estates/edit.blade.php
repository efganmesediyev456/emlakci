{{-- estates/edit.blade.php --}}
@extends('backend.layouts.layout')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4>Əmlak dəyişdir</h4>
                <div class="buttons">
                    <a href="{{ route('admin.estates.index') }}" class="btn btn-success">
                        <i class="fas fa-arrow-left"></i>
                        <span class="wmax">Geriyə qayıt</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{route('admin.estates.update', $item->id)}}" method="POST" id="saveForm" enctype="multipart/form-data">
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title_{{$language->code}}" class="form-label">Ad ({{$language->code}})</label>
                                    <input type="text" class="form-control"
                                        name="title[{{$language->code}}]"
                                        id="title_{{$language->code}}"
                                        placeholder="Ad daxil edin" 
                                        value="{{  $item->translate($language->code)?->title }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="address_{{$language->code}}" class="form-label">Ünvan ({{$language->code}})</label>
                                    <input type="text" class="form-control"
                                        name="address[{{$language->code}}]"
                                        id="address_{{$language->code}}"
                                        placeholder="Ünvan daxil edin" 
                                        value="{{ $item->translate($language->code)?->address}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="location_{{$language->code}}" class="form-label">Məkan ({{$language->code}})</label>
                                    <input type="text" class="form-control"
                                        name="location[{{$language->code}}]"
                                        id="location_{{$language->code}}"
                                        placeholder="Məkan daxil edin"
                                        value="{{  $item->translate($language->code)?->location }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="district_{{$language->code}}" class="form-label">Rayon ({{$language->code}})</label>
                                    <input type="text" class="form-control"
                                        name="district[{{$language->code}}]"
                                        id="district{{$language->code}}"
                                        placeholder="Rayon daxil edin" value="{{  $item->translate($language->code)?->district }}">
                                </div>
                            </div>

                             <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="subtitle_{{$language->code}}" class="form-label">Qısa başlıq ({{$language->code}})</label>
                                    <input type="text" class="form-control"
                                        name="subtitle[{{$language->code}}]"
                                        id="subtitle{{$language->code}}"
                                        placeholder="Qısa başlıq daxil edin" value="{{  $item->translate($language->code)?->subtitle }}">
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug_{{$language->code}}" class="form-label">Slug {{$language->code}}</label>
                                    <input type="text" class="form-control" name="slug[{{$language->code}}]"
                                        id="slug_{{$language->code}}"
                                        placeholder="Slug daxil edin"
                                        value="{{  $item->translate($language->code)?->slug }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="seo_description_{{$language->code}}" class="form-label">Seo Haqqında {{$language->code}}</label>
                                    <textarea class="form-control" name="seo_description[{{$language->code}}]"
                                        id="seo_description_{{$language->code}}"
                                        placeholder="Haqqında daxil edin">{{ $item->translate($language->code)?->seo_description}}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="seo_keywords_{{$language->code}}" class="form-label">Açar sözlər {{$language->code}}</label>
                                    <input type="text" class="form-control tagsview" name="seo_keywords[{{$language->code}}]"
                                        id="seo_keywords_{{$language->code}}"
                                        placeholder="Açar sözlər daxil edin"
                                        value="{{$item->translate($language->code)?->seo_keywords}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description_{{$language->code}}" class="form-label">Haqqında {{$language->code}}</label>
                                    <textarea class="form-control ckeditor" name="description[{{$language->code}}]"
                                        id="description_{{$language->code}}"
                                        placeholder="">{{$item->translate($language->code)?->description}}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    @endforeach
                </div>

                <!-- Estate specific fields -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="price" class="form-label">Qiymət</label>
                            <input type="number" step="0.01" name="price" class="form-control" placeholder="Qiymət daxil edin" value="{{$item->price}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="area" class="form-label">Sahə (m²)</label>
                            <input type="number" step="0.01" name="area" class="form-control" placeholder="Sahə daxil edin" value="{{$item->area}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="rooms" class="form-label">Otaq sayı</label>
                            <input type="number" name="rooms" class="form-control" placeholder="Otaq sayı" value="{{$item->rooms}}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="floor" class="form-label">Mərtəbə</label>
                            <input type="number" name="floor" class="form-control" placeholder="Mərtəbə" value="{{$item->floor}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="total_floors" class="form-label">Ümumi mərtəbə</label>
                            <input type="number" name="total_floors" class="form-control" placeholder="Ümumi mərtəbə" value="{{$item->total_floors}}">
                        </div>
                    </div>

                      <div class="col-md-4">
                        <div class="mb-3">
                            <label for="call_number" class="form-label">Telefon zəngi üçün nömrə</label>
                            <input type="number" name="call_number" class="form-control" placeholder="Telefon zəngi üçün nömrə daxil edin" value="{{ $item->call_number }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="whatsapp_number" class="form-label">Whatsapp üçün nömrə</label>
                            <input type="number" name="whatsapp_number" class="form-control" placeholder="Whatsapp üçün nömrə daxil edin" value="{{ $item->whatsapp_number }}">
                        </div>
                    </div>


                     <div class="col-md-4">
                        <div class="mb-3">
                            <label for="total_floors" class="form-label">Ölkə</label>
                            <select  name="country_id" class="form-select" id="country_id">
                                <option>Seçin</option>
                                @foreach($countries as $country)
                                    <option @selected($item->country_id == $country->id) value="{{ $country->id }}">{{$country->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="total_floors" class="form-label">Şəhər</label>
                            <select  name="city_id" class="form-select" id="city_id">
                                <option>Seçin</option>
                                @if($cities)
                                @foreach($cities as $city)
                                    <option @selected($item->city_id == $city->id) value="{{ $city->id }}">{{$city->title}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                </div>

               

                <!-- Features checkboxes -->
                <div class="row">
                    <div class="col-md-12">
                        <label class="form-label">Xüsusiyyətlər</label>
                        <div class="row">

                           

                              <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="mortgage" value="1" id="mortgage" {{$item->mortgage ? 'checked' : ''}}>
                                    <label class="form-check-label" for="mortgage">İpotekaya yararlı</label>
                                </div>
                            </div>


                              <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_vip" value="1" id="is_vip" {{$item->is_vip ? 'checked' : ''}}>
                                    <label class="form-check-label" for="is_vip">Vip</label>
                                </div>
                            </div>


                             <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="has_extract" value="1" id="has_extract" {{$item->has_extract ? 'checked' : ''}}>
                                    <label class="form-check-label" for="has_extract">Çıxarış var</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_new" value="1" id="has_extract" {{$item->is_new ? 'checked' : ''}}>
                                    <label class="form-check-label" for="has_extract">Yeni</label>
                                </div>
                            </div>

                             @foreach($properties as $property)
                             <div class="col-md-3">
                                <div class="form-check">
                                    <input @checked($item->properties->contains($property->id)) class="form-check-input" type="checkbox" name="properties[{{ $property->id }}]" value="1" id="property_{{ $property->id }}">
                                    <label class="form-check-label" for="property_{{ $property->id }}">{{ $property->title }}</label>
                                </div>
                            </div>
                            @endforeach
                           
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="">Şəkil</label>
                            <input type="file" name="image" class="form-control">
                            @if($item->image)
                                <img width="300" src="/storage/{{$item->image}}" alt="">
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="">Əmlak növü</label>
                            <select name="type_estate_id" class="form-control form-select">
                                <option value="">Seçin</option>
                                @foreach($type_estates as $type)
                                    <option @selected($type->id == $item->type_estate_id) value="{{ $type->id }}">{{$type->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="">Satış növləri</label>
                            <select name="type_purchase_id" class="form-control form-select">
                                <option value="">Seçin</option>
                                @foreach($type_purchases as $type)
                                    <option @selected($type->id == $item->type_purchase_id) value="{{ $type->id }}">{{$type->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                   
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="">Xəritə</label>
                            <input type="text" name="map" class="form-control" value="{{ $item->map }}">
                        </div>
                    </div>

                </div>

                <!-- Multiple Media Files Section -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>Çoxlu Fayllar</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="media_files" class="form-label">Fayllar Əlavə Et</label>
                                    <input type="file" name="media_files[]" class="form-control" multiple>
                                    <small class="text-muted">Birdən çox fayl seçə bilərsiniz</small>
                                </div>
                                
                                <!-- Existing Media Files -->
                                @if($item->media && $item->media->count() > 0)
                                <div class="mt-4">
                                    <h6>Mövcud Fayllar</h6>
                                    <div class="row">
                                        @foreach($item->media as $media)
                                        <div class="col-md-3 mb-3">
                                            <div class="card">
                                                <img src="/storage/{{$media->file}}" class="card-img-top" alt="Media">
                                                <div class="card-body p-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="delete_media[]" value="{{$media->id}}" id="delete_media_{{$media->id}}">
                                                            <label class="form-check-label" for="delete_media_{{$media->id}}">
                                                                Sil
                                                            </label>
                                                        </div>
                                                        <input type="number" class="form-control form-control-sm" style="width: 70px;" name="media_order[{{$media->id}}]" value="{{$media->order}}" placeholder="Sıra">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
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


@push("js")
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector("#country_id").addEventListener("change", function () {
            var country_id = this.value;

            fetch("{{ route('admin.estates.cities') }}", {
                method: "POST",
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    country_id: country_id
                })
            })
            .then(response => response.json())
            .then(data => {
                 document.querySelector("#city_id").innerHTML = data.view
            })
            .catch(err => {
                console.error(err);
            });
        });
    });
</script>
@endpush