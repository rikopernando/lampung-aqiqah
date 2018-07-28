<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
            <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:400,500,700,400italic|Material+Icons">
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <style type="text/css">
            .spinner:before { 
                content: ''; 
                box-sizing: border-box; 
                position: absolute; 
                top: 50%; 
                left: 50%; 
                width: 20px; 
                height: 20px; 
                margin-top: -10px; 
                margin-left: -10px; 
                border-radius: 50%; 
                border: 2px solid #ccc; 
                border-top-color: #333; 
                animation: spinner .6s linear infinite; 
            } 
            .selectizeLoading > .selectize-input, .selectizeLoading > .selectize-input > input {
                cursor: wait !important;
                font-style: italic;
                background:
                url('http://www.hsi.com.hk/HSI-Net/pages/images/en/share/ajax-loader.gif')
                no-repeat
                center center;
            }
        </style>

        </head>
    <body style="background-color: white;">
        <div id="app">
            <router-view></router-view>
        </div>
        <script src="{{ asset('js/app.js?v=1.21')}}" type="text/javascript"></script>
    </body>
</html>
