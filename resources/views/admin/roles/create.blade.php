@extends('admin.layouts.app')
@section('content')
<div class="card">
    <div class="card-body">
    <div class="ic-role">
        <form action="{{ route('roles.store') }}" method="POST" id="form">
            @csrf
            <div class="ic_form row mb_24">
                <div class="col-lg-8">
                    <label class="form-label">{{__('Role Name')}}</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                        placeholder="{{__('Enter role name')}}">
                </div>
            </div>
            <div class="ic_form mb_24">
                <div class="form-check">
                    <input type="checkbox" name="parent_id" class="form-check-input" id="customCheck-all"
                        value="all">
                    <label class="form-check-label mt-1" for="exampleCheck1">{{__('Check All Permissions')}}</label>
                </div>
            </div>
            <!-- accordian -->
            <div class="ic_form gx-xxl-4 gx-xl-3 gx-sm-2 row">
                @foreach ($permissions as $i => $permission)
                    @if ($permission->parent_id === null)
                        <div class="col-md-4 col-sm-6 mb_24">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item" data-id="{{ $permission->id }}">
                                    <h2 class="accordion-header" id="role_{{ $permission->id }}">
                                        <div class="ic-check-all">
                                            <input type="checkbox" name="permissions[]" class="form-check-input"
                                                id="customCheck-{{ $permission->id }}"
                                                onchange="loadChildren({{ $permission->id }})"
                                                value="{{ $permission->name }}">
                                            <label class="form-check-label" for="add-role_{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseRole_{{ $permission->id }}" aria-expanded="true"
                                            aria-controls="collapseRole_{{ $permission->id }}">
                                        </button>
                                    </h2>
                                    <div id="collapseRole_{{ $permission->id }}"
                                        class="accordion-collapse collapse {{ $i == 0 ? 'show' : '' }}"
                                        aria-labelledby="role_{{ $permission->id }}"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            @foreach ($permission->childs as $children)
                                                <div class="form-check">
                                                    <div class="form-check">
                                                        <input type="checkbox"
                                                            class="form-check-input parent-identy-{{ $permission->id }}"
                                                            name="permissions[]" id="customCheck-{{ $children->id }}"
                                                            value="{{ $children->name }}">
                                                        <label class="form-check-label"
                                                            for="customCheck-{{ $children->id }}">{{ $children->name }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="d-flex justify-content-end">
                <div class="right-button-group ">
                    <a href="{{ route('roles.index') }}" class="ic-button white">{{__('Cancel')}}</a>
                    <button type="submit" class="ic-button primary">{{__('Submit')}}</button>
                </div>
            </div>
        </form>
    </div>
    </div>
</div>
@endsection
@push('style')
    <style>
        .ic_parent_permission {
            background-color: #b4bfcc;
            color: black;
            border-radius: 5px;
        }
    </style>
@endpush
@push('script')
    <script>
            $(document).ready(function() {
                $("#customCheck-all").click(function() {
                    $('input:checkbox').not(this).prop('checked', this.checked);
                    $('div .ic_div-show').toggle();
                });
            })

            function loadChildren(parent_id) {

                $(`#ic_parent-${parent_id}`).toggle();

                if ($(`#customCheck-${parent_id}`).is(':checked')) {
                    $(`.parent-identy-${parent_id}`).each(function() {
                        $(this).prop('checked', true);
                    });
                } else {
                    $(`.parent-identy-${parent_id}`).each(function() {
                        $(this).prop('checked', false);
                    });
                }
            }
        </script>
@endpush
