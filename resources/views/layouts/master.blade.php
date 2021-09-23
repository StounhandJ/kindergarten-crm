<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8"/>
    <title>@yield('title')</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('/assets/images/favicon.ico') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts.head')
</head>


@section('body')
    <body data-sidebar="dark" style="padding-right: 17px;">
    <div id="preloader">
        <div id="status">
            <div class="spinner-chase">
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
            </div>
        </div>
    </div>
    @show

    <!-- Begin page -->
    <div id="layout-wrapper">
    @include('layouts.topbar')
    @include('layouts.sidebar')
    <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                @yield('table-add-btn')
                <div class="container-fluid table-scroll">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            {{-- @include('layouts.footer') --}}
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    @include('layouts.footer-script')
    {{--    <div class="modal-backdrop fade show"></div>--}}
    </body>

</html>
