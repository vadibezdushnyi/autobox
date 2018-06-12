
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0"/>
    <meta name="format-detection" content="telephone=no">
    <title>{{ $_page->meta_title }}</title>

    <meta name="robots" content="{{ $_page->indexing==1 ? 'index, follow' : 'noindex, nofollow' }}" />
    <meta name="description" content="{{ $_page->meta_desc }}" />
    <meta name="keywords" content="{{ $_page->meta_keys }}" />
    <meta name="author" content="KAM Studio" />

    @if($_route == 'post')
      <meta property="og:title" content="{{ $post->name }}">
      <meta property="og:description" content="{{ $post->content }}">
      <meta property="og:url" content="http://beta24.com">
      <meta property="og:site_name" content="beta24"/>
      <meta property="og:type" content="website" />
      <meta property="og:image" content="{{ url($post->cover) }}">
      <meta property="og:image:width" content="600">
      <meta property="og:image:height" content="315">
      <meta property="og:image:type" content="image/jpeg">
    @endif

    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ url('/public/img/favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ url('/public/img/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ url('/public/img/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ url('/public/img/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ url('/public/img/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ url('/public/img/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ url('/public/img/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ url('/public/img/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('/public/img/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ url('/public/img/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('/public/img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ url('/public/img/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('/public/img/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ url('/public/img/favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ url('/public/img/favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    <!-- end favicon -->
    
    <link rel="stylesheet" href="{{ url('/public/css/base.css') }}">
    @if(in_array($_route, ['profile','orders','order','cart','discounts','security','balance','pricelists','product','products']))
    <link rel="stylesheet" href="{{ url('/public/css/user.css') }}">
    @endif
    <link rel="stylesheet" href="{{ url('/public/css/__.css') }}">
    <link rel="stylesheet" href="{{ url('/public/css/chat.css') }}">

    <!--[if IE]>
        <script src="{{ url('/public/js/respond.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/es5-shim/4.5.7/es5-shim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/es5-shim/4.5.7/es5-sham.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/json3/3.3.2/json3.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/es6-shim/0.34.2/es6-shim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/es6-shim/0.34.2/es6-sham.min.js"></script>
        <script src="https://wzrd.in/standalone/es7-shim@latest"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <![endif]-->

  </head>
  <body class="{{ $_bodyclass }}">
    @include('elements.header')
    @yield('content')
    @include('elements.footer')
    @include('elements.modals')
    @include('elements.scripts')
  </body>
  {{ csrf_field() }}
</html>
