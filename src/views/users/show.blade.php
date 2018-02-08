@extends('Permissionview::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12"> 
                <div>
                
                    <ol class="breadcrumb">
                        <li><a href="{!! route('user.index') !!}">User</a></li> 
                        <li><b>User show </b></li>
                    </ol>
                </div> 
                <br><br>
                <a class=" btn btn btn-primary pull-right" href="{!! route('user.edit', [$user->id]) !!}">Edit</a> 
                <br><br>
                <table class="table table-striped">
                 
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td><h4>{{ $user->$userName }} </h4></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><h4>{{ $user->email }}</h4></td>
                        </tr> 
                        <tr>
                            <td>Direct permissions</td>
                            <td>
                                <div class="row">
                                @foreach($user->getDirectPermissions()  as $permission ) 
                                    <div class="col-md-3 text-danger"> <h4> {!! $permission->name !!} </h4> </div> 
                                @endforeach 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>roles</td>
                            <td> 
                                
                                @foreach($user->roles as $role)
                                    <h3 class="text-info">{{ $role->name }}</h3> 
        
                                    <div class="row">
                                        @foreach($role->permissions as $permission ) 
            
                                            <div class="col-md-3 text-danger"><h4>&nbsp;&nbsp;&nbsp;&nbsp;{!! $permission->name !!}</h4></div> 
                                        
                                        @endforeach 
                                    </div>
                                @endforeach
                                
                            </td>
                        </tr>
                    </tbody> 
                </table>
            </div>
        </div>
    </div>
@endsection