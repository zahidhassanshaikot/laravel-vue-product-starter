@extends('layouts.app')

@section('content')
<div class="col-lg-12 p-0">
    <div class="card">
        <div class="card-body">
            <h4 class="header-title">{{ __('Add User') }}</h4>
            <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-xl-4 col-lg-6 p-2">
                        <label>{{ __('Name') }} <span class="error">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Name" required
                            value="{{ old('name') }}">

                        @error('name')
                        <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-xl-4 col-lg-6 p-2">
                        <label>{{ __('Email') }} <span class="error">*</span></label>
                        <input type="email" name="email" class="form-control" required placeholder="Enter email"
                            value="{{ old('email') }}">

                        @error('email')
                        <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-xl-4 col-lg-6 p-2">
                        <label>{{ __('Phone') }}</label>
                        <input type="tel" value="{{ old('phone') ? old('phone') : '+1' }}" name="phone"
                            class="form-control phone">

                        @error('phone')
                        <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-xl-4 col-lg-6 p-2">
                        <label>{{ __('Password') }} <span class="error">*</span></label>
                        <input type="password" name="password" class="form-control" required
                            placeholder="Enter password">

                        @error('password')
                        <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-xl-4 col-lg-6 p-2">
                        <label>{{ __('Confirm Password') }} <span class="error">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required
                            placeholder="Type password again">

                        @error('password_confirmation')
                        <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-xl-4 col-lg-6 p-2">
                        <label>{{ __('Avatar') }}</label>
                        <small>({{ __('Image size max 300kb') }})</small>
                        <div class="ic-form-group position-relative">
                            <input type="file" id="uploadFile" class="f-input form-control" name="avatar">
                        </div>
                        @error('avatar')
                        <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-xl-4 col-lg-6 p-2">
                        <label>{{ __('Role') }} <span class="error">*</span></label>
                        <div>
                            @if($roles)
                            <select name="role" class="form-control">
                                <option value="">{{ __('Select Role') }}</option>
                                @foreach($roles as $role)
                                <option value=" {{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @endif
                        </div>
                        @error('role')
                        <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-xl-4 col-lg-6 p-2">
                        <label>{{ __('User Type') }} <span class="error">*</span></label>
                        <div>
                            <select name="type" class="form-control">
                                <option value="">{{ __('Select User Type') }}</option>
                                <option value="Admin" selected="selected">{{ __('Admin') }}</option>
                                <option value="Manager">{{ __('Manager') }}</option>
                            </select>
                        </div>
                        @error('type')
                        <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-xl-4 col-lg-6 p-2">
                        <div class="row">
                            <label class="d-block mb-3 col-md-12">{{ __('Status') }} <span class="error">*</span></label>
                            <div class="custom-control custom-radio custom-control-inline col-md-6">
                                <input type="radio" id="status_yes" value="{{ \App\Models\User::STATUS_ACTIVE }}"
                                       name="status" class="custom-control-input" checked="">
                                <label class="custom-control-label" for="status_yes">{{ __('Active') }}</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline col-md-6">
                                <input type="radio" id="status_no" value="{{ \App\Models\User::STATUS_INACTIVE }}"
                                       name="status" class="custom-control-input">
                                <label class="custom-control-label" for="status_no">{{ __('Inactive') }}</label>
                            </div>
                        </div>


                        @error('status')
                        <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <button class="btn btn-primary waves-effect waves-lightml-2" type="submit">
                            <i class="fa fa-save"></i> {{ __('Submit') }}
                        </button>
                        <a class="btn btn-danger waves-effect" href="{{ route('users.index') }}">
                            <i class="fa fa-times"></i> {{ __('Cancel') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> <!-- end col -->
@endsection

@push('style')
@endpush
@push('script')
@endpush
