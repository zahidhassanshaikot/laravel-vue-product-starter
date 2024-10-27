@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('roles.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="ic_role_name">Role Name</label>
                            <input type="text" class="form-control ic_custom-form-input" id="ic_role_name" autocomplete="off" name="name" placeholder="Enter Role Name" required value="{{old('name')}}">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row my-2">
                            <div class="col-8 pt-1">
                                <div class="custom-control" style="padding-left: 0px;">
                                    <label for="customCheck-all">All Permissions</label>
                                </div>
                            </div>
                            <div class="col-4 pt-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="parent_id" class="custom-control-input" id="customCheck-all" value="all">
                                    <label class="custom-control-label" for="customCheck-all"></label>
                                </div>
                            </div>
                        </div>

                        @foreach ($permissions as $i => $permission)
                            <div class="row ic_parent_permission my-2">
                                <div class="col-8 pt-1">
                                    <div class="custom-control" style="padding-left: 0px">
                                        <label for="customCheck-{{$permission->id}}"><strong>{{$permission->name}} All</strong></label>
                                    </div>
                                </div>
                                <div class="col-4 pt-1">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="parent_id" class="custom-control-input" id="customCheck-{{$permission->id}}" onchange="loadChildren({{$permission->id}})">
                                        <label class="custom-control-label" for="customCheck-{{$permission->id}}"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row ic_div-show" id="ic_parent-{{$permission->id}}" style="display: none;transition: all 10s ease">
                                @foreach ($permission->childs as $children)
                                    <div class="col-8 pt-1">
                                        <div class="custom-control" style="padding-left: 0px">
                                            <label for="customCheck-{{$children->id}}">{{$children->name}}</label>
                                        </div>
                                    </div>
                                    <div class="col-4 pt-1">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="permissions[]" class="custom-control-input parent-identy-{{$permission->id}}" id="customCheck-{{$children->id}}" value="{{$children->id}}">
                                            <label class="custom-control-label" for="customCheck-{{$children->id}}"></label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                        <div class="form-group mt-4">
                            <div>
                                <button class="btn btn-primary waves-effect waves-lightml-2" type="submit">
                                    <i class="fa fa-save"></i> Submit
                                </button>
                                <a class="btn btn-secondary waves-effect" href="{{ route('roles.index') }}">
                                    <i class="fa fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>

                    </form>
                </div>
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
        $("#customCheck-all").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
            $('div .ic_div-show').toggle();
        });

        function loadChildren(parent_id) {

            $(`#ic_parent-${parent_id}`).toggle();

            if ($(`#customCheck-${parent_id}`).is(':checked')){
                $(`.parent-identy-${parent_id}`).each(function(){
                    $(this).prop('checked', true);
                });
            }else{
                $(`.parent-identy-${parent_id}`).each(function(){
                    $(this).prop('checked', false);
                });
            }
        }
    </script>
@endpush
