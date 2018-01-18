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
                            <td><h4> {{ $role->name }} </h4></td>
                        </tr>
                        <tr>
                            <td>Users</td>
                            <td> 
                                <div class="row">
                                    @foreach($role->users as $user ) 
                                        <div class="col-md-3 text-info" ><h4> {!! $user->email !!} </h4></div> 
                                    @endforeach 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Permissions</td>
                            <td>
                                <div class="row">
                                @foreach($role->permissions as $permission ) 
    
                                    <div class="col-md-4 text-danger">
                                        <h4> {!! $permission->name !!} </h4>
                                    </div> 
                                   
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