<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <title>{{ getPageMeta('title') }} | {{ systemSettings('site_title') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ storagelink(config('settings.site_favicon')) }}">

    @include('admin.layouts.partials.styles')
</head>

<body>

<div class="account-pages my-5 pt-5">
    <div class="container">
        @yield('content')
    </div>
</div>

<!-- JAVASCRIPT -->
@include('admin.layouts.partials.scripts')

</body>
</html>
