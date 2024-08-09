<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $campaign->title }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="d-flex justify-content-center align-items-center min-vw-100 min-vh-100 flex-column">
        @if ($campaign->target)
            <div class="spinner-border" style="width: 4rem; height: 4rem;" role="status">
                <span class="visually-hidden"></span>
            </div>
            <p class="m-5" id="loading">Loading...</p>
        @else
            <h1 class="m-5">{{ $campaign->title }}</h1>
        @endif
    </div>
    </div>
    <script>
        if ("{{ $campaign->target }}") {
            setTimeout(function() {
                window.location.href = "{{ $campaign->target }}"
            }, 2000);
        }
    </script>
</body>

</html>
