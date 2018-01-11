@extends('Permissionview::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div>
                
                    <ol class="breadcrumb">
                        <li><a href="{!! route('permission.index') !!}">Permission</a></li> 
                        <li><b>Permission create </b></li>
                    </ol>
                </div>
                    {!! Form::open(['route' => 'permission.store']) !!}

                        @include ('Permissionview::permissions.form') 

                        {!! Form::submit('add', array('class' => 'btn btn-primary')) !!}

                    {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection