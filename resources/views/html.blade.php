<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} v{{ app('package.version') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>

<body>

    <div class="uk-section uk-section-small">
        <div class="uk-container uk-container-small">
            <h1 class="uk-heading-primary uk-flex uk-flex-middle uk-flex-center">
                <span>Laravel-Phone</span>
                <a href="https://github.com/propaganistas/laravel-phone" class="uk-margin-small-left" uk-icon="icon: github; ratio: 2"></a>
            </h1>
        </div>
    </div>

    <div class="uk-section uk-section-small" uk-height-viewport="expand: true">
        <div class="uk-container">
            @yield('content')
        </div>
    </div>

    <div class="uk-section uk-section-muted uk-section-small">
        <div class="uk-container uk-text-center uk-text-small">
            <div class="uk-margin-small-bottom">
                This demo runs on
            </div>
            <div uk-grid class="uk-grid-collapse uk-child-width-1-1@m uk-child-width-1-3@l">
                <div>
                    <a href="https://github.com/laravel/framework">
                        <code>laravel/framework&commat;{{ app('illuminate.version') }}</code>
                    </a>
                </div>
                <div>
                    <a href="https://github.com/giggsey/libphonenumber-for-php">
                        <code>giggsey/libphonenumber-for-php&commat;{{ app('libphonenumber.version') }}</code>
                    </a>
                </div>
                <div>
                    <a href="https://github.com/propaganistas/laravel-phone">
                        <code>propaganistas/laravel-phone&commat;{{ app('package.version') }}</code>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ mix('js/uikit.js') }}"></script>

    @yield('scripts')
</body>
</html>
