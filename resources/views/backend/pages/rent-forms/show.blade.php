@extends('backend.layouts.layout')

@section('content')
    <div class="container">
        <!-- item Details Card -->
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Əmlak kirayə #{{ $item->id }} - Ətraflı məlumat</h4>
                    <a href="{{ route('admin.forms.rentForm') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Sifarişlər siyahısına qayıt
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row"> 
                    <!-- Customer Information Column -->
                    <div class="col-md-6">
                        <h5 class="mb-3">Müştəri məlumatları</h5>
                        <table class="table table-bitemed">
                            <tr>
                                <th>Ad Soyad:</th>
                                <td>{{ $item->name }}</td>
                            </tr>
                            <tr>
                                <th>Əlaqə nömrəsi:</th>
                                <td>{{ $item->phone }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $item->email }}</td>
                            </tr>
                            <tr>
                                <th>Əmlak növü:</th>
                                <td>
                                    {{ $item->typeEstate?->title }}
                                </td>
                            </tr>
                            <tr>
                                <th>Tarix:</th>
                                <td>
                                    {{ $item->created_at->format('Y-m-d H:i:s') }} - {{ $item->created_at->diffForHumans() }} 
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Delivery Information Column -->
                    <div class="col-md-6">
                        <h5 class="mb-3">Məhsul məlumatları</h5>
                        <table class="table table-bitemed">
                            <tr>
                                <th>Ölkə:</th>
                                <td>{{ $item->country?->title }}</td>
                            </tr>
                            <tr>
                                <th>Şəhər :</th>
                                <td>{{ $item->city?->title }}</td>
                            </tr>
                             <tr>
                                <th>Otaq sayı :</th>
                                <td>{{ $item->rooms }}</td>
                            </tr>
                               <tr>
                                <th>Mərtəbə  :</th>
                                <td>{{ $item->floors }}</td>
                            </tr>
                            </tr>
                               <tr>
                                <th>Evin sahəsi aralığı m ilə  :</th>
                                <td>{{ $item->min_area .' - '.$item->max_area }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

      
    </div>
@endsection

