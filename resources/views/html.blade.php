<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} {{ config('app.package_version') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <span class="navbar-brand" href="javascript:void(0);">{{ config('app.name') }} ({{ config('app.package_version') }})</span>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <form class="navbar-form navbar-right">
                    <div class="form-group">
                        <label for="count"># Fields:</label>
                        <input type="text" id="count" name="count" class="form-control navbar-count" value="{{ request('count', 1) }}">
                    </div>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">

        @yield('content')

    </div>

    <script src="{{ mix('js/app.js') }}"></script>

    @yield('scripts')
</body>
</html>
