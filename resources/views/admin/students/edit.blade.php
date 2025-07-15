@extends('admin.layouts.app')
@section('content')
    <div class="col-lg-12 p-0">
        <div class="card">
            <div class="card-body">
                {{--                <h4 class="header-title">{{ __('Edit User') }}</h4> --}}
                <form action="{{ route('students.update', $user->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <h4 class="header-title">{{ __('Basic Info') }}</h4>
                    <hr />
                    <div class="row">
                        <div class="form-group col-xl-4 col-lg-6 p-2">
                            <label>{{ __('First Name') }} <span class="error">*</span></label>
                            <input type="text" name="first_name" class="form-control"
                                placeholder="{{ __('First Name') }}" required
                                value="{{ old('first_name', $user->first_name) }}">

                            @error('first_name')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-xl-4 col-lg-6 p-2">
                            <label>{{ __('Last Name') }} <span class="error">*</span></label>
                            <input type="text" name="last_name" class="form-control" placeholder="{{ __('Last Name') }}"
                                required value="{{ old('last_name', $user->last_name) }}">

                            @error('last_name')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-xl-4 col-lg-6 p-2">
                            <label>{{ __('Email') }} <span class="error">*</span></label>
                            <input type="email" name="email" class="form-control" required
                                placeholder="{{ __('Enter email') }}" value="{{ old('email', $user->email) }}">

                            @error('email')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-xl-4 col-lg-6 p-2">
                            <label>{{ __('Phone') }}</label>
                            <input type="tel" value="{{ old('phone') ? old('phone') : $user->phone }}" name="phone"
                                class="form-control phone">

                            @error('phone')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-xl-4 col-lg-6 p-2">
                            <label>{{ __('Gender') }}</label>
                            <select name="gender" class="form-control">
                                <option {{ old('gender', $user->gender) == 1 ? 'selected' : '' }} value="1">
                                    {{ __('Male') }}</option>
                                <option {{ old('gender', $user->gender) == 0 ? 'selected' : '' }} value="0">
                                    {{ __('Female') }}</option>
                                <option {{ old('gender', $user->gender) == 2 || $user->gender == null ? 'selected' : '' }}
                                    value="2">{{ __('Rather Not Say') }}</option>
                            </select>

                            @error('gender')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group col-xl-4 col-lg-6 p-2">
                            <label>{{ __('Date Of Birth') }} <span class="error">*</span></label>
                            <input type="date" name="dob" class="form-control"
                                placeholder="{{ __('Date Of Birth') }}" required
                                value="{{ old('dob', optional($user->studentProfile)->dob) }}">

                            @error('dob')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group col-xl-4 col-lg-6 p-2">
                            <label>{{ __('Password') }} </label>
                            <input type="password" name="password" class="form-control"
                                placeholder="{{ __('Enter password') }}">

                            @error('password')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-xl-4 col-lg-6 p-2">
                            <label>{{ __('Confirm Password') }} </label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="{{ __('Type password again') }}">

                            @error('password_confirmation')
                                {{--                            <p class="error">{{ $message }}</p> --}}
                            @enderror
                        </div>

                        <div
                            class="form-group col-xl-4 col-lg-6 p-2 {{ auth()->user()->id == $user->id ? 'd-none' : '' }}">
                            <div class="row">
                                <label class="d-block mb-3 col-md-12">{{ __('Status') }} <span
                                        class="error">*</span></label>
                                <div class="d-flex gap-2">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="status_yes" value="{{ \App\Models\User::STATUS_ACTIVE }}"
                                            name="status" class="custom-control-input me-2"
                                            {{ old('status', $user->status) == \App\Models\User::STATUS_ACTIVE ? 'checked=""' : '' }}>
                                        <label class="custom-control-label" for="status_yes">{{ __('Active') }}</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="status_no"
                                            value="{{ \App\Models\User::STATUS_INACTIVE }}" name="status"
                                            class="custom-control-input me-2"
                                            {{ old('status', $user->status) == \App\Models\User::STATUS_INACTIVE ? 'checked=""' : '' }}>
                                        <label class="custom-control-label" for="status_no">{{ __('Inactive') }}</label>
                                    </div>
                                </div>
                            </div>

                            @error('status')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-xl-4 col-lg-6 p-2">
                            <label>{{ __('Avatar') }}</label>
                            <small>({{ __('Image size max 300kb') }})</small>
                            <div class="row">
                                <div class="col-lg-8 col-md-12 col">
                                    <div class="ic-form-group position-relative">
                                        <input type="file" id="uploadFile" class="f-input form-control image_pick"
                                            data-image-for="avatar" name="avatar" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <img class="img-64 mt-0 mt-md-0" src="{{ $user->avatar_url }}" id="img_avatar"
                                        alt="avatar" />
                                </div>
                            </div>
                            @error('avatar')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-xl-12 col-lg-12 p-2">
                            <label>{{ __('Bio') }} </label>
                            <textarea name="about" class="form-control" rows="3">{{ old('about', optional($user->studentProfile)->about) }}</textarea>

                            @error('about')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>


                    <h4 class="header-title">{{ __('License Info') }}</h4>
                    <hr />
                    <div class="row">
                        <div class="form-group col-xl-4 col-lg-6 p-2">
                            <label>{{ __('Medical license') }} </label>
                            <input type="text" name="medical_license" class="form-control"
                                placeholder="{{ __('Medical license') }}"
                                value="{{ old('medical_license', optional($user->studentProfile)->medical_license) }}">,

                            @error('medical_license')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group col-xl-4 col-lg-6 p-2">
                            <label>{{ __('License Type') }} </label>
                            <select name="license_type" class="form-control">
                                <option
                                    {{ old('license_type', optional($user->studentProfile)->license_type) == 'passport' ? 'selected' : '' }}
                                    value="passport">{{ __('Passport') }}</option>
                                <option
                                    {{ old('license_type', optional($user->studentProfile)->license_type) == 'national_id' ? 'selected' : '' }}
                                    value="national_id">{{ __('National ID') }}</option>
                                <option
                                    {{ old('license_type', optional($user->studentProfile)->license_type) == 'driving_license' ? 'selected' : '' }}
                                    value="driving_license">{{ __('Driving License') }}</option>
                                <option
                                    {{ old('license_type', optional($user->studentProfile)->license_type) == 'other' ? 'selected' : '' }}
                                    value="other">{{ __('Other') }}</option>
                            </select>
                            @error('license_type')
                                <p class="error">{{ $message }}</p>
                            @enderror

                        </div>

                        <div class="form-group col-xl-4 col-lg-6 p-2">
                            <label>{{ __('License Number') }} </label>
                            <input type="text" name="license_number" class="form-control"
                                placeholder="{{ __('License Number') }}"
                                value="{{ old('license_number', optional($user->studentProfile)->license_number) }}">

                            @error('license_number')
                                <p class="error">{{ $message }}</p>
                            @enderror

                        </div>

                    </div>

                    <h4 class="header-title">{{ __('Address Info') }}</h4>
                    <hr />
                    <div class="row">
                        <div class="form-group col-xl-4 col-lg-6 p-2">
                            <label>{{ __('Country') }} </label>
                            <input type="text" name="country" class="form-control" placeholder="{{ __('Country') }}"
                                value="{{ old('country', optional($user->studentProfile)->country) }}">

                            @error('country')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-xl-4 col-lg-6 p-2">
                            <label>{{ __('State') }} </label>
                            <input type="text" name="state" class="form-control" placeholder="{{ __('State') }}"
                                value="{{ old('state', optional($user->studentProfile)->state) }}">

                            @error('state')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-xl-4 col-lg-6 p-2">
                            <label>{{ __('City') }} </label>
                            <input type="text" name="city" class="form-control" placeholder="{{ __('City') }}"
                                value="{{ old('city', optional($user->studentProfile)->city) }}">

                            @error('city')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-xl-4 col-lg-6 p-2">
                            <label>{{ __('Zip Code') }} </label>
                            <input type="text" name="zip_code" class="form-control"
                                placeholder="{{ __('Zip Code') }}"
                                value="{{ old('zip_code', optional($user->studentProfile)->zip_code) }}">

                            @error('zip_code')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-xl-8 col-lg-6 p-2">
                            <label>{{ __('Address') }} </label>
                            <textarea name="address" class="form-control" placeholder="{{ __('Address') }}">{{ old('address', optional($user->studentProfile)->address) }}</textarea>
                            {{--                        <input type="text" name="address" class="form-control" placeholder="{{__('Address')}}" --}}
                            {{--                            value="{{ old('address') }}"> --}}

                            @error('address')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <h4 class="header-title">{{ __('Social Info') }}</h4>
                    <hr />
                    <div class="row">
                        <div class="form-group col-xl-4 col-lg-6 p-2">
                            <label>{{ __('Facebook') }} </label>
                            <input type="url" name="facebook" class="form-control"
                                placeholder="{{ __('Facebook') }}"
                                value="{{ old('facebook', optional($user->studentProfile)->facebook) }}">

                            @error('facebook')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-xl-4 col-lg-6 p-2">
                            <label>{{ __('Twitter') }} </label>
                            <input type="url" name="twitter" class="form-control" placeholder="{{ __('Twitter') }}"
                                value="{{ old('twitter', optional($user->studentProfile)->twitter) }}">

                            @error('twitter')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-xl-4 col-lg-6 p-2">
                            <label>{{ __('Linkedin') }} </label>
                            <input type="url" name="linkedin" class="form-control"
                                placeholder="{{ __('Linkedin') }}"
                                value="{{ old('linkedin', optional($user->studentProfile)->linkedin) }}">

                            @error('linkedin')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-xl-4 col-lg-6 p-2">
                            <label>{{ __('Instagram') }} </label>
                            <input type="url" name="instagram" class="form-control"
                                placeholder="{{ __('Instagram') }}"
                                value="{{ old('instagram', optional($user->studentProfile)->instagram) }}">

                            @error('instagram')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-xl-4 col-lg-6 p-2">
                            <label>{{ __('Youtube') }} </label>
                            <input type="url" name="youtube" class="form-control"
                                placeholder="{{ __('Youtube') }}"
                                value="{{ old('youtube', optional($user->studentProfile)->youtube) }}">

                            @error('youtube')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-xl-4 col-lg-6 p-2">
                            <label>{{ __('Website') }} </label>
                            <input type="url" name="website" class="form-control"
                                placeholder="{{ __('Website') }}"
                                value="{{ old('website', optional($user->studentProfile)->website) }}">
                            @error('website')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mt-1 mb-0">
                        <div class="d-flex justify-content-end">
                            <div class="right-button-group">
                                <a href="{{ route('students.index') }}"
                                    class="ic-button white">{{ __('Cancel') }}</a>
                                <button type="submit" class="ic-button primary">{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> <!-- end col -->
@endsection


@push('style')
    <style>
        hr {
            border: none;
            border-top: 3px double #000000;
            color: #333;
            overflow: visible;
            text-align: center;
            height: 5px;
        }

        hr::after {
            background: #fff;
            content: '§';
            padding: 0 4px;
            position: relative;
            top: -13px;
        }
    </style>
@endpush

@push('script')
@endpush
