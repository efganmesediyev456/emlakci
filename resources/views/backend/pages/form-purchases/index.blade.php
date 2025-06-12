@extends('backend.layouts.layout')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4>Əmlak almaq</h4>
               
            </div>
        </div>
        <div class="card-body">
            @if(@session()->has('success'))
                <div class="alert alert-success">{{session('success')}}</div>
            @endif
            {{ $dataTable->table() }}
        </div>
    </div>
</div>

@endsection

@push('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush