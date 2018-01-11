@extends('Permissionview::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div>
                
                    <ol class="breadcrumb">
                        <li><a href="{!! route('permissionModel.index') !!}">permissionModel</a></li> 
                        <li><b>permissionModel edit </b></li>
                    </ol>
                </div>

                    {!! Form::model($permissionModel, ['method' => 'PATCH', 'route' => ['permissionModel.update', $permissionModel->id]]) !!}

                        @include ('Permissionview::permissionModels.form') 


                        {!! Form::submit('update', array('class' => 'btn btn-primary')) !!}

                    {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection