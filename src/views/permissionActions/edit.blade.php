@extends('Permissionview::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div>
                
                    <ol class="breadcrumb">
                        <li><a href="{!! route('permissionAction.index') !!}">permissionAction</a></li> 
                        <li><b>permissionAction edit </b></li>
                    </ol>
                </div>

                    {!! Form::model($permissionAction, ['method' => 'PATCH', 'route' => ['permissionAction.update', $permissionAction->id]]) !!}

                        @include ('Permissionview::permissionActions.form') 


                        {!! Form::submit('update', array('class' => 'btn btn-primary')) !!}

                    {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection