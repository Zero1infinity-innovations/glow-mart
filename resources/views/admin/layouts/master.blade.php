<!doctype html>
<html lang="en" class="semi-light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    @include('admin.layouts.header')
    <link rel="shortcut icon" href="{{ asset('assets/images/app/logo.jpeg') }}" type="image/x-icon">
    <title>@stack('title') | {{env('APP_NAME')}}</title>
    @stack('css')
</head>
<body>

    <!--wrapper-->
    <div class="wrapper">
        <!--sidebar wrapper -->
        <div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header" style="padding-left: 4rem; padding-top: 3.5rem; padding-bottom: 5rem;">
                <div >
                    <center><img style="width: 90px;" src="{{ asset('assets/images/app/glowmart.webp') }}" class="logo-icon" alt="logo icon"></center>  
                </div>
                <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i></div>
            </div>
            <!--navigation-->
            @include('admin.layouts.left-menu')
            <!--end navigation-->
        </div>
        <!--end sidebar wrapper -->
        <!--start header -->

        @include('admin.layouts.top-menu')
        <!--end header -->
        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content" id="parent">
                <div id="content">
                    {{-- <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                        <div class="breadcrumb-title pe-3 cursor-pointer" onclick="window.history.back()">
                            <div>Back</div>
                        </div>
                        <div class="ps-3">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 p-0 ">
                                    <li class="breadcrumb-item "><a href="{{ route('admin.dashboard') }}"><i class='bx bx-home-smile'></i></a>
                                    </li>
                                    <li class="breadcrumb-item active " aria-current="page">@stack('title')</li>
                                </ol>
                            </nav>
                        </div>
                    </div> --}}
                    @yield('content')
                </div>
            </div>
        </div>
        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->
        <!--Start Back To Top Button-->
        <!--End Back To Top Button-->
        <footer class="page-footer">
            <p class="mb-0">Copyright © 2024. All right reserved.</p>
        </footer>
    </div>
    @include('admin.layouts.script')
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    @stack('script')
</body>
</html>
