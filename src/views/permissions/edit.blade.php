@extends('Permissionview::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div>
                
                    <ol class="breadcrumb">
                        <li><a href="{!! route('permission.index') !!}">Permission</a></li> 
                        <li><b>Permission edit </b></li>
                    </ol>
                </div>

                    {!! Form::model($permission, ['method' => 'PATCH', 'route' => ['permission.update', $permission->id]]) !!}

                        @include ('Permissionview::permissions.form') 


                        {!! Form::submit('update', array('class' => 'btn btn-primary')) !!}

                    {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection