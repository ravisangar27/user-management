@extends('Permissionview::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2">
                <div>
                
                    <ol class="breadcrumb">
                        <li><a href="{!! route('permissionAction.index') !!}">permissionAction</a></li> 
                        <li><b>permissionAction create </b></li>
                    </ol>
                </div>
                    {!! Form::open(['route' => 'permissionAction.store']) !!}

                        @include ('Permissionview::permissionActions.form') 

                        {!! Form::submit('add', array('class' => 'btn btn-primary')) !!}

                    {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection