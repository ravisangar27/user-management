@extends('Permissionview::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2"> 
                <div>
                
                    <ol class="breadcrumb">
                        <li><a href="{!! route('role.index') !!}">Role</a></li> 
                        <li><b>Role show </b></li>
                    </ol>
                </div> 
                <br><br>
                <a class=" btn btn btn-primary pull-right" href="{!! route('role.edit', [$role->id]) !!}">Edit</a> 
                <br><br>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td>{{ $role->name }}</td>
                        </tr>
                        <tr>
                            <td>Users</td>
                            <td> 
                                <div class="row">
                                    @foreach($role->users as $user ) 
                                        <div class="col-md-3" >{!! $user->email !!}</div> 
                                    @endforeach 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>
                                <div class="row">
                                @foreach($role->permissions as $permission ) 
    
                                    <div class="col-md-3" style="color:{!! '#'.dechex(rand(0x000000, 0xFFFFFF)) !!}">{!! $permission->name !!}</div> 
                                   
                                @endforeach 
                                </div>
                            </td>
                        </tr>
                    </tbody> 
                </table>
            </div>
        </div>
    </div>
@endsection