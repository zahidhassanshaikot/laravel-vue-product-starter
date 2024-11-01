@extends('admin.layouts.auth')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-4">
            <div class="card overflow-hidden">
                <div class="bg-primary">
                    <div class="text-primary text-center p-4">
                        <h5 class="text-white font-size-20">Welcome Back !</h5>
                        <p class="text-white-50">Sign in to continue to {{ config('settings.site_title') }}.</p>
                        <a href="{{ url('/') }}" class="logo logo-admin">
                            <img src="{{ getStorageImage(config('settings.site_logo'),false,'logo') }}" height="24" alt="logo">
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="p-3">
                        <form class="mt-4" method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" id="email" placeholder="Enter email" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="userpassword">Password</label>
                                <input type="password" name="password" required class="form-control" id="userpassword" placeholder="Enter password">
                            </div>

                            <div class="mb-3 row">
                                <div class="col-sm-6">
                                    <div class="form-check">
                                        <input type="checkbox" name="remember" class="form-check-input" id="customControlInline">
                                        <label class="form-check-label" for="customControlInline">Remember me</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-end">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
                                </div>
                            </div>

{{--                            @if(Route::has('password.request'))--}}
{{--                                <div class="mt-2 mb-0 row">--}}
{{--                                    <div class="col-12 mt-4">--}}
{{--                                        <a href="{{ route('password.request') }}"><i class="mdi mdi-lock"></i> Forgot your password?</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}

                        </form>

                    </div>
                </div>

            </div>

            <div class="mt-5 text-center">
                <p class="mb-0">© {{ date('Y') }}
                    {{ config('settings.site_title') }}. Crafted with <i class="mdi mdi-heart text-danger"></i> by Zahid Hassan Shaikot</p>
            </div>


        </div>
    </div>
@endsection
