<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>@yield('title') - Axie Infinity</title>
    <!-- Fonts -->
    <link rel="shortcut icon" href="{{ asset('public/logo.png') }}"/>
    <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/style.css?ver=1.1.1') }}" rel="stylesheet">
    <link href="{{ asset('public/css/chosen.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/jquery.datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/all.css') }}" rel="stylesheet">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{ asset('public/js/jquery.min.js') }}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ asset('public/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('public/js/chosen.jquery.min.js') }}"></script>
    <script src="{{ asset('public/js/jquery.mask.js') }}"></script>
    <script src="{{ asset('public/js/mainHeader.js') }}"></script>
    <script src="{{ asset('public/js/jquery.datetimepicker.full.min.js') }}"></script>
    <script src="{{ asset('public/js/jquery.inputmask.min.js') }}"></script>
    
    <script src="{{ asset('public/js/xlsx.full.min.js') }}"></script>
    <script src="{{ asset('public/js/jszip.js') }}"></script>


</head>
<body class="@yield('class')">

@include('layouts.header')
<div id="content">
    <div class="container">
        <!-- Content Wrapper. Contains page content -->

        <div class="row">
            <div class="col-md-12">
                <h1 class="text-left text-uppercase pageTitle">  @yield('titlePage')</h1>
            </div>
        </div>
        @if($errors->any())
            {!! implode('', $errors->all('<div>:message</div>')) !!}
        @endif
        @if(session('success'))
            <div class="alert alert-success">
                {!! session('success') !!}
            </div>
        @endif
        @if(session('message'))
            <div class="alert alert-success">
                {!! session('message') !!}
            </div>
        @endif
        @yield('content')
    </div>
</div>
@include('layouts.footer')
</body>
</html>
