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

                    <div class="form-group {!! ($errors->has('confirm_password')) ? 'has-error' : '' !!}"> 
                            {!! Form::label('users', 'Users') !!}
                            <select class="js-example-basic-multiple" value="admin" style="width:100%" name="userIds[]" multiple="multiple">
                            @foreach($users as $user) 
                                @if($user->hasDirectPermission($permission->name))
                                    <option selected='selected' value="{{ $user->id }}">{{ $user->email }}</option>
                           
                                @else
                                    <option value="{{ $user->id }}">{{ $user->email }}</option>
                                @endif
                            @endforeach 

                            </select> 
                        </div> 

                        <div class="form-group {!! ($errors->has('confirm_password')) ? 'has-error' : '' !!}"> 
                            {!! Form::label('roles', 'Roles') !!}
                            <select class="js-example-basic-multiple" value="admin" style="width:100%" name="roleIds[]" multiple="multiple">
                            @foreach($roles as $role) 
                                @if($role->hasPermissionTo($permission->name))
                                    <option selected='selected' value="{{ $role->id }}">{{ $role->name }}</option>
                           
                                @else
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endif
                            @endforeach 

                            </select> 
                        </div>


                        {!! Form::submit('update', array('class' => 'btn btn-primary')) !!}

                    {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection