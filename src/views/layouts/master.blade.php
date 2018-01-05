<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>
    <!-- styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> 

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <script>
        window.app = {!! json_encode([
            'csrfToken' => csrf_token()
        ]) !!};
    </script> 
    <style>
        .rotate-45{
           // transform: rotate(-85deg); 
          //  transform-origin: 20% 40%;
           
            }
    </style>
</head>
<body>
    <div id="app">
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>       
   <script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    }); 
    </script>
</body>
</html>