@extends('backend.layouts.layout')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4>Əmlak</h4>
                <div class="buttons">
                    <a href="{{ route('admin.estates.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i>
                        <span class="wmax">Yenisini yarat</span>
                    </a>
                </div>
            </div>
        </div>


         <div class="card-body border-bottom">
            <form id="filter-form" class="row g-3">
                
                
                <div class="col-md-2">
                    <label for="country_filter" class="form-label">Ölkə</label>
                    <select id="country_filter" class="form-select">
                        <option value="">Hamısı</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->title }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label for="city_filter" class="form-label">Şəhər</label>
                    <select id="city_filter" class="form-select">
                        <option value="">Hamısı</option>
                        @foreach($cities as  $city)
                            <option value="{{ $city->id }}">{{ $city->title }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-2">
                    <label for="foreign" class="form-label">Yerli Xarici</label>
                    <select id="foreign" class="form-select">
                        <option value="">Hamısı</option>
                        <option value="0">Yerli</option>
                        <option value="1">Xarici</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label for="type_estate_filter" class="form-label">Əmlak Növü</label>
                    <select id="type_estate_filter" class="form-select">
                        <option value="">Hamısı</option>
                        @foreach($typeEstates as $id => $title)
                            <option value="{{ $title->id }}">{{ $title->title }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label for="type_purchase_filter" class="form-label">Alış Növü</label>
                    <select id="type_purchase_filter" class="form-select">
                        <option value="">Hamısı</option>
                        @foreach($typePurchases as $id => $title)
                            <option value="{{ $title->id }}">{{ $title->title }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Qiymət Aralığı</label>
                    <div class="input-group">
                        <input type="number" id="min_price" class="form-control" placeholder="Min">
                        <span class="input-group-text">-</span>
                        <input type="number" id="max_price" class="form-control" placeholder="Max">
                    </div>
                </div>


                
                
                <div class="col-md-3">
                    <label class="form-label">Sahə Aralığı</label>
                    <div class="input-group">
                        <input type="number" id="min_area" class="form-control" placeholder="Min">
                        <span class="input-group-text">-</span>
                        <input type="number" id="max_area" class="form-control" placeholder="Max">
                    </div>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Tarix Aralığı</label>
                    <div class="input-group">
                        <input type="date" id="start_date" class="form-control">
                        <span class="input-group-text">-</span>
                        <input type="date" id="end_date" class="form-control">
                    </div>
                </div>
                
                <div class="col-md-2 d-flex align-items-end">
                    <div class="d-flex">
                        <button type="button" id="filter-btn" class="btn btn-primary me-2 d-flex align-items-center gap-2">
                        <i class="fas fa-filter"></i> Filterlə
                    </button>
                    <button type="button" id="reset-filter" class="btn btn-secondary d-flex align-items-center gap-2">
                        <i class="fas fa-undo"></i> Sıfırla
                    </button>
                    </div>
                </div>
            </form>
        </div>
        

        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>
</div>

@endsection

@push('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

      <script>
        $(document).ready(function() {
             $('#filter-btn').click(function() {
                window.LaravelDataTables['estates-table'].draw();
            });

             $('#reset-filter').click(function() {
                $('#filter-form')[0].reset();
                window.LaravelDataTables['estates-table'].draw();
            });
        });

         document.addEventListener("DOMContentLoaded", function () {
        document.querySelector("#country_filter").addEventListener("change", function () {
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
                 document.querySelector("#city_filter").innerHTML = data.view
            })
            .catch(err => {
                console.error(err);
            });
        });
    });
    </script>
@endpush