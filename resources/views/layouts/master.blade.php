<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="@yield('page_description', 'Deň po dni sledujeme vývoj Nežnej revolúcie v denníku Júliusa Kollera a prostredníctvom fotografií, plagátov, rozhovorov a videí spoznávame kreativitu občanov, ich požiadavky, názory a nádeje.')">
  <meta property="og:title" content="@yield('page_title', 'Čas-opis 1989')" />
  <meta property="og:description" content="@yield('page_description', 'Deň po dni sledujeme vývoj Nežnej revolúcie v denníku Júliusa Kollera a prostredníctvom fotografií, plagátov, rozhovorov a videí spoznávame kreativitu občanov, ich požiadavky, názory a nádeje.')">
  <meta property="og:keywords" content="November 1989, Nežná revolúcia, Július Koller, Verejnosť proti násiliu, plagáty, Čas-opis" />
  <meta property="og:type" content="website" />
  <meta property="og:author" content="http://lab.sng.sk/" />
  <meta property="og:url" content="{{ url()->current() }}" />
  <meta property="og:image" content="@yield('og_image', asset('/images/Og-Cas-OPIS.png'))" />
  <meta property="og:site_name" content="Čas-opis 1989" />
  @show

  <title>@yield('page_title', 'Čas-opis 1989')</title>

  <!-- Favicons-->
  <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">

  @yield('link')


  <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
  @stack('styles')

  @if (App::environment() == 'production' && config('app.ga_code'))
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', '{{ config('app.ga_code') }}', 'auto');
    ga('send', 'pageview');

  </script>
  @endif

</head>

<body class="@yield('body-class', '')">
  @include('components.menu')

  <div id="overlay">
  </div>
    <div id="app">
      @yield('content')
    </div>
  <script type="text/javascript" src="{{ mix('/js/manifest.js') }}"></script>
  <script type="text/javascript" src="{{ mix('/js/vendor.js') }}"></script>
  <script type="text/javascript" src="{{ mix('/js/app.js') }}"></script>

  @stack('scripts')

</body>

</html>
