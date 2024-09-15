<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="/nl-logo.png" />
        <title>Perfume - Devandur</title>
        <script src="https://kit.fontawesome.com/f5fc8fd02c.js" crossorigin="anonymous"></script>
        @vite(['./resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div id="app"></div>
    </body>
</html>
