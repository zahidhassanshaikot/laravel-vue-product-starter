@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="ic-datatable">
                {!! $dataTable->table(['class' => 'nowrap']) !!}
            </div>
        </div>
    </div>
@endsection

@push('style')
    @include('layouts.partials.datatableCss')
@endpush
@push('script')
    @include('layouts.partials.dataTablejs')

@endpush
