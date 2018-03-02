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
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-left"> 
                        @if (optional(auth()->user())->hasRole('super-admin'))
                        <li class="{{ Request::segment(1) === 'permissionModel' ? 'active' : null }}"><a href="{!! route('permissionModel.index') !!}">Permission model</a></li> 
                        <li class="{{ Request::segment(1) === 'permissionAction' ? 'active' : null }}"><a href="{!! route('permissionAction.index') !!}">Permission action</a></li> 
                        @endif
                        <li class="{{ Request::segment(1) === 'permission' ? 'active' : null }}"><a href="{!! route('permission.index') !!}">Permission</a></li>
                        <li class="{{ Request::segment(1) === 'role' ? 'active' : null }}"><a href="{!! route('role.index') !!}">Role</a></li>
                        <li class="{{ Request::segment(1) === 'user' ? 'active' : null }}"><a href="{!! route('user.index') !!}">User</a></li>
                        @if (optional(auth()->user())->hasRole('super-admin'))
                        <li class="{{ Request::segment(1) === 'activity' ? 'active' : null }}"><a href="{!! route('activity.index') !!}">Activity</a></li>
                        @endif
                    </ul> 
                </div>
            </div>
        </nav>
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>       
   <script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    }); 
    </script> 
     @section('javascript')

      @show
</body>
</html>