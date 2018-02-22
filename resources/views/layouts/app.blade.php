<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Miembros ICCN</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">


    <!-- Scripts -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

    <script src="https://use.typekit.net/jhn7mqk.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>


  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-101400669-1', 'auto');
  ga('send', 'pageview');

</script>

</head>
<body>
    <div id="app">
        <empresa></empresa>
        <register></register>
        <poplogin></poplogin>
        <navigation userid="{{ Auth::check() ? Auth::id() : 0 }}"></navigation>

        @yield('content')

        @include('partials.footer')
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
</body>
</html>
