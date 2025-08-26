<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('meta-title')</title>
    <meta name="title" content="@yield('meta-title')">
    <meta name="description" content="@yield('meta-description')">
    <meta name="keywords" content="@yield('meta-keywords')">

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="@yield('meta-title')">
    <meta itemprop="description" content="@yield('meta-description')">
    <meta itemprop="image" content="@yield('meta-image')">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('line-awesome/css/line-awesome.min.css') }}">
    <link href="{{ asset('front/css/style2.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    {{-- Call custom inline styles --}}
    @yield('styles')
</head>

<body>
    <div id="app">
        @include('partial.nav')
        <main class="content">
            @yield('content')
        </main>
        {{-- @include('partial.footer') --}}
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script src="{{ asset('front/js/style.js') }}" defer></script>
    <script src="{{ asset('toastr/toastr.min.js') }}"></script>

    {{-- Call custom inline scripts --}}

    {{-- Toast Messages --}}
    @if (session()->has('success'))
        <script>
            toastr.success(`{{ Session::get('success') }}`, 'EQR')
        </script>
    @elseif (session()->has('error'))
        <script>
            toastr.error(`{{ Session::get('error') }}`, 'EQR')
        </script>
    @elseif (session()->has('message'))
        <script>
            toastr.info(`{{ Session::get('message') }}`, 'EQR')
        </script>
    @endif
    {{-- End Toast Messages --}}

    @yield('scripts')
</body>

</html>
