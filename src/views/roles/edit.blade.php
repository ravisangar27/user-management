@extends('Permissionview::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div>
                
                    <ol class="breadcrumb">
                        <li><a href="{!! route('role.index') !!}">Role</a></li> 
                        <li><b>Role edit </b></li>
                    </ol>
                </div>

                    {!! Form::model($role, ['method' => 'PATCH', 'route' => ['role.update', $role->id]]) !!}

                        @include ('Permissionview::roles.form') 

                      
                        
                        <table class="table table-striped table-header-rotated">
                        <thead> 
                            <tr> 
                                <th></th>
                                @foreach($permissionActions as $action)
                                <th><div class="rotate-45"><span>{!! $action['display_name'] !!}</span></div></th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                        
                            @foreach($permissionModel as $model)
                            <tr>
                                <td>{!! $model['display_name'] !!}</td>
                                @foreach($permissionActions as $action)
                                <td>
                                    @if($permission->where('name', $model['name'].'-'.$action['name'])->count())  
                                            @if($role->hasPermissionTo($model['name'].'-'.$action['name']))
                                                {!! Form::checkbox($model['name'].'.'.$action['name'] ,1  , true) !!}
                                            @else
                                                {!! Form::checkbox($model['name'].'.'.$action['name']), '' !!}
                                            @endif
                                        @endif
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                                </tbody>
                            </table>  

                        {!! Form::submit('update', array('class' => 'btn btn-primary')) !!}

                    {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection