@extends('Permissionview::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
               

                    {!! Form::model($user, ['method' => 'PATCH', 'route' => ['user.update', $user->id]]) !!}

                        @include ('Permissionview::users.form') 

                        <div class="form-group {!! ($errors->has('confirm_password')) ? 'has-error' : '' !!}"> 
                            {!! Form::label('roles', 'Roles') !!}
                            <select class="js-example-basic-multiple" value="admin" style="width:100%" name="roles[]" multiple="multiple">
                            @foreach($roles as $role) 
                                @if($user->hasRole($role->name))
                                    <option selected='selected' value="{{ $role->name }}">{{ $role->name }}</option>
                           
                                @else
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endif
                            @endforeach 

                            </select> 
                        </div>

                        <table class="table table-striped table-header-rotated">
                            <thead> 
                                <tr> 
                                    <th></th>
                                    @foreach($modelsActions['actions'] as $action)
                                    <th><div class="rotate-45"><span>{!! $action['display_name'] !!}</span></div></th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modelsActions['models'] as $model)
                                <tr>
                                    <td>{!! $model['display_name'] !!}</td>
                                    @foreach($modelsActions['actions'] as $action)
                                    <td>
                                        @if(array_search($action['name'], $modelsActions['modelActions'][$model['name']]) || array_search($action['name'], $modelsActions['modelActions'][$model['name']]) === 0 )   
                                            @if($user->hasPermissionTo($model['name'].' '.$action['name']))
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