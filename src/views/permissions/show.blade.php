@extends('Permissionview::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2"> 
                <div>
                
                    <ol class="breadcrumb">
                        <li><a href="{!! route('permission.index') !!}">Permission</a></li> 
                        <li><b>Permission show </b></li>
                    </ol>
                </div> 
                <br><br>
                <a class=" btn btn btn-primary pull-right" href="{!! route('permission.edit', [$permission->id]) !!}">Edit</a> 
                <br><br>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td>{{ $permission->name }}</td>
                        </tr>
                        <tr>
                            <td>Users</td>
                            <td>
                                <div class="row">
                                    @foreach($permission->users as $user ) 
                                        <div class="col-md-3" >{!! $user->email !!}</div> 
                                    @endforeach 
                                </div>
                            </td>
                        </tr> 
                        <tr>
                            <td>roles</td>
                            <td>    
                                <div class="row">
                                    @foreach($permission->roles as $role ) 
                                        <div class="col-md-3" >{!! $role->name !!}</div> 
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