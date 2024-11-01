@extends('admin.layouts.auth')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-4">
            <div class="card overflow-hidden">
                <div class="bg-primary">
                    <div class="text-primary text-center p-4">
                        <h5 class="text-white font-size-20">Verify Email</h5>
                        <a href="{{ url('/') }}" class="logo logo-admin">
                            <img src="{{ storagelink(config('settings.site_logo')) }}" height="24" alt="logo">
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="p-3">
                        <div class="alert alert-success mt-5" role="alert">
                            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
                        </div>
                        @if (session('status') == 'verification-link-sent')
                            <div class="alert alert-success mt-1" role="alert">
                                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                            </div>
                        @endif

                        <form class=" mt-4" method="POST" action="{{ route('verification.send') }}">
                            @csrf

                            <div class="row  mb-0">
                                <div class="col-12 text-end">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Resend Verification Email</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

            </div>

            <div class="mt-5 text-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button class="btn btn-link w-md waves-effect waves-light" type="submit">Log Out</button>
                </form>

                <p class="mb-0">© {{ date('Y') }}
                    {{ config('settings.site_title') }}. Crafted with <i class="mdi mdi-heart text-danger"></i> by Zahid Hassan Shaikot</p>
            </div>

        </div>
    </div>
@endsection
