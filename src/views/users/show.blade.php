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
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ $user->email }}</td>
                        </tr> 
                        <tr>
                            <td>Direct permissions</td>
                            <td>
                                <div class="row">
                                @foreach($user->getDirectPermissions()  as $permission ) 
    
                                    <div class="col-md-3" style="color:{!! '#'.dechex(rand(0x000000, 0xFFFFFF)) !!}">{!! $permission->name !!}</div> 
                                   
                                @endforeach 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>roles</td>
                            <td> 
                                
                                @foreach($user->roles as $role)
                                    <h3 style="color:{!! '#'.dechex(rand(0x000000, 0xFFFFFF)) !!}" >{{ $role->name }}</h3> 
                                    <br> 
                                    <div class="row">
                                        @foreach($role->permissions as $permission ) 
            
                                            <div class="col-md-3" style="color:{!! '#'.dechex(rand(0x000000, 0xFFFFFF)) !!}">{!! $permission->name !!}</div> 
                                        
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