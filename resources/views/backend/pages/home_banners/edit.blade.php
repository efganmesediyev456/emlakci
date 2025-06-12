@extends('backend.layouts.layout')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4>Banner Reklam</h4>
                <div class="buttons">
                    <a href="{{ route('admin.home_banners.index') }}" class="btn btn-success">
                        <i class="fas fa-arrow-left"></i>
                        <span class="wmax">Geriyə qayıt</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{route('admin.home_banners.update', $item->id)}}" method="POST" id="saveForm" enctype="multipart/form-data">
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
                                        placeholder="Ad daxil edin" value="{{ $item->translate($language->code)?->title }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="description_{{$language->code}}" class="form-label">Haqqında {{$language->code}}</label>
                                    <textarea class="form-control" name="description[{{$language->code}}]"
                                        id="description_{{$language->code}}"
                                        placeholder=""
                                        value="">{{$item->translate($language->code)?->description}}</textarea>
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
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="">Şəkil</label>
                            <input type="file" name="image" class="form-control">
                            @if($item->image)
                                <img width="300" src="/storage/{{$item->image}}" alt="">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="url" class="form-label">URL</label>
                            <input type="text" class="form-control" name="url" id="url" placeholder="URL daxil edin" value="{{ $item->url }}">
                        </div>
                    </div>

                       <div class="col-md-4">
                        <div class="mb-3">
                            <label for="total_floors" class="form-label">Ölkə</label>
                            <select  name="country_id" class="form-select" id="country_id">
                                <option value="">Seçin</option>
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
                                <option value="">Seçin</option>
                                @if($cities)
                                @foreach($cities as $city)
                                    <option @selected($item->city_id == $city->id) value="{{ $city->id }}">{{$city->title}}</option>
                                @endforeach
                                @endif
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