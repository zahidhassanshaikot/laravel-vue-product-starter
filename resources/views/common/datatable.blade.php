@extends('admin.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="ic-datatable">
                {!! $dataTable->table(['class' => 'nowrap']) !!}
            </div>
        </div>
    </div>
@endsection


@include('common.common-modal')

@push('style')
    @include('admin.layouts.partials.datatableCss')

    <style>
        .content-header {
            font-size: 17px;
            text-align: center;
            font-weight: 500;
        }
        .content-header p {
            margin: 0
        }
    </style>
@endpush
@push('script')
    @include('admin.layouts.partials.dataTablejs')
@endpush
