<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Fazwaz</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/js/datatable/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/js/datatable/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
        </style>
    </head>
    <body>
        <div id="app">
            <router-view></router-view>
        </div>
        <script type="text/javascript" src="{{ asset('/js/app.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js/datatable/jquery.dataTables.min.js') }}"></script>
        
        </script>
    </body>
</html>