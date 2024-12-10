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
    <link rel="shortcut icon" href="{{ getStorageImage(config('settings.site_favicon'),false,'favicon') }}">
    @vite('resources/js/app.js')
    @include('admin.layouts.partials.styles')
</head>

<body data-sidebar="dark">

<div>
    <!-- Begin page -->
    <div id="layout-wrapper">

        @include('admin.layouts.partials.header')

        <!-- ========== Left Sidebar Start ========== -->
        @include('admin.layouts.partials.sidebar')
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div id="vueApp" class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    @include('admin.layouts.partials.breadcrumb')
                    <!-- end page title -->


                    <!-- Start Your Main Content Here-->
                    @yield('content')

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            @include('admin.layouts.partials.footer')

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->
</div>

<!-- JAVASCRIPT -->
@include('admin.layouts.partials.scripts')

</body>
</html>
