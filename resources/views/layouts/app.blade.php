<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EC Site</title>
    @vite(['resources/css/app.css', 'resources/js/app.ts'])
</head>

<body>
    <div id="app">
        @yield('content')
    </div>
</body>

</html>
