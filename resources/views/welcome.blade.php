<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
            <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Aqiqah Lampung</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:400,500,700,400italic|Material+Icons">
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="{{ asset('css/dashboard-admin.css') }}">

    </head>
    <body style="background-color:white;">
        <div id="app">
            <router-view></router-view>
        </div>
        <script src="{{ asset('js/app.js?v=1.66')}}" type="text/javascript"></script>
        <!-- jQuery CDN - Slim version (=without AJAX) -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <!-- Popper.JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js">
        </script>
        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js">
        </script>

        <script src="{{ asset('js/accounting.min.js') }}"></script>
        
        <script type="text/javascript">
            $(document).ready(function () {
                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar').toggleClass('active');
                    $(this).toggleClass('active');
                });
            });
        </script>

    </body>
</html>
