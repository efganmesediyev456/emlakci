@extends('backend.layouts.layout')

@section('content')


    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Dillər</h4>
                    <div class="buttons">
                        <a href="{{ route('admin.languages.create') }}" class="btn btn-success">Yenisini yarat</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>


@endsection


@push('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
