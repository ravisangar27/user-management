@extends('Permissionview::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Guard name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody> 
                        @foreach($roles as $role)
                            <tr>
                                <td>{{  $role->name }}</td> 
                                <td>{{  $role->guard_name }}</td>
                                <td> 
                                <a href="{!! route('role.edit', [$role->id]) !!}">Edit </a>&nbsp;&nbsp;
                                <a href="{!! route('role.destroy', [$role->id]) !!}">Delete</i>  </a>
                                </td>
                            </tr> 
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
