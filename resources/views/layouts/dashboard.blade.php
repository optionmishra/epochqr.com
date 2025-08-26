<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('tracklead/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('line-awesome/css/line-awesome.min.css') }}">

    {{-- Call custom inline styles --}}
    @yield('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <div class="headerTop">
            @include('admin.partial.topbar')
        </div>

        @include('admin.partial.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    @yield('breadcumb')
                </div>
            </div>

            <section class="content">
                <div class="container-fluid px-1">
                    @yield('content')
                </div>
            </section>
        </div>

        {{-- @include('admin.partial.footer') --}}

    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('tracklead/js/style.js') }}" defer></script>

    {{-- Call custom inline scripts --}}
    @yield('scripts')
</body>

</html>
