<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vue/Laravel SSR App</title>
    <link rel="stylesheet" type="text/css" href="./css/app.css" />
    
</head>

<body>
    {{-- Begin of Vue SSR --}}
    {!! ssr('js/app-server.js')
        ->fallback('<div id="app"></div>')
        ->render() !!}
    {{-- End of Vue SSR --}}
    <script defer src="{{ mix('js/app-client.js') }}"></script>
</body>

</html>