@extends('Permissionview::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div>
                
                    <ol class="breadcrumb">
                        <li><a href="{!! route('user.index') !!}">User</a></li> 
                        <li><b>User create </b></li>
                    </ol>
                </div>
                    {!! Form::open(['route' => 'user.store']) !!}

                        @include ('Permissionview::users.form') 

                        <div class="form-group {!! ($errors->has('email')) ? 'has-error' : '' !!}">
                            {!! Form::label('email', 'Email') !!}
                            {!! Form::email('email', null, array('class' => 'form-control email', 'placeholder' => '' )) !!}
                            {!! ($errors->has('email') ? $errors->first('email') : '') !!}
                        </div>   

                        <div class="form-group {!! ($errors->has('password	')) ? 'has-error' : '' !!}">
                            {!! Form::label('password', 'Password') !!}
                            {!! Form::password('password',  array('class' => 'form-control awesome' )) !!}
                            {!! ($errors->has('password	') ? $errors->first('password	') : '') !!}
                        </div> 

                        <div class="form-group {!! ($errors->has('password_confirmation')) ? 'has-error' : '' !!}">
                            {!! Form::label('password_confirmation', 'Confirm password') !!}
                            {!! Form::password('password_confirmation',  array('class' => 'form-control', 'placeholder' => '' )) !!}
                            {!! ($errors->has('password_confirmation') ? $errors->first('password_confirmation') : '') !!}
                        </div> 

                        <div class="form-group {!! ($errors->has('confirm_password')) ? 'has-error' : '' !!}"> 
                            {!! Form::label('roles', 'Roles') !!}
                            <select class="js-example-basic-multiple role" value="admin" style="width:100%" name="roles[]" multiple="multiple">
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach

                            </select> 
                        </div>
                           
                        
                        <table class="table table-striped table-header-rotated">
                        <thead> 
                            <tr> 
                                <th></th>
                                @foreach($permissionActions as $action)
                                <th class="text-center"><div class="rotate-45"><span>{!! $action['display_name'] !!}</span></div></th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                        
                            @foreach($permissionModel as $model)
                            <tr>
                                <td>{!! $model['display_name'] !!}</td>
                                @foreach($permissionActions as $action)
                                <td class="{!! $model['name'].'-'.$action['name']  !!} text-center ">
                                    @if($permission->where('name', $model['name'].'-'.$action['name'])->count())
                                    
                                        {!! Form::checkbox($model['name'].'-'.$action['name']), '' !!}
                                    
                                     @endif
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>  
            
                        {!! Form::submit('add', array('class' => 'btn btn-primary')) !!}

                    {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        var roles = {!! $roles !!};
    
        $('.role').change( function(){ 
            $( "td" ).removeClass( "bg-info" )
            rolePermission($(this).val());
        });

        function rolePermission(selectedRoles){
            roles.filter(function(role) {
                return selectedRoles.indexOf(role.name) > -1;
            }).forEach(function(selectedRole) {
                selectedRole.permissions.forEach(function(permission) {
                    $("."+permission.name).addClass( "bg-info" );
                });
            });
        }
    }); 
   //  $('.email').trigger('change');
</script>
@endsection