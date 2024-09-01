<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="/nl-logo.png" />
        <title>Perfume - Devandur</title>
        @vite(['resources/css/Admin/adminApp.css', 'resources/js/Admin/adminApp.js'])
    </head>
    <body>
        <div id="appAdmin"></div>
    </body>
</html>
