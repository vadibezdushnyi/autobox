@extends('layouts.app')
@section('content')
<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
<style>
    .cc {text-align: center;display: table-cell;vertical-align: middle;margin: 0;padding: 20vh 0 10vh;width: 100%;display: table;}
    .ct {text-align: center;display: inline-block;}
    .title {font-size: 72px;margin-bottom: 40px;font-weight: 100;font-family: 'Lato';color: #B0BEC5;}
</style>
<main>
  <div class="cc">
      <div class="ct">
        <div class="title" style="font-size:100px;">{{ $viewname }}</div>
      </div>
  </div>
</main>
@endsection
