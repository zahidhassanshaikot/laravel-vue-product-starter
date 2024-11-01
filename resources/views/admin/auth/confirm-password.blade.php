@extends('admin.layouts.auth')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-4">
            <div class="card overflow-hidden">
                <div class="bg-primary">
                    <div class="text-primary text-center p-4">
                        <h5 class="text-white font-size-20">Confirm Password</h5>
                        <a href="{{ url('/') }}" class="logo logo-admin">
                            <img src="{{ storagelink(config('settings.site_logo')) }}" height="24" alt="logo">
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="p-3">
                        <div class="alert alert-success mt-5" role="alert">
                            This is a secure area of the application. Please confirm your password before continuing.
                        </div>

                        <form class=" mt-4" method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="password">Password</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Enter password">
                            </div>

                            <div class="row  mb-0">
                                <div class="col-12 text-end">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Confirm</button>
                                </div>
                            </div>

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
