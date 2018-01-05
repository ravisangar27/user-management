@extends('Permissionview::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th> 
                            <th>Roles</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody> 
                        @foreach($users as $user)
                            <tr>
                                <td>{{  $user->name }}</td> 
                                <td>{{  $user->email }}</td> 
                                <td>{{  $user->getRoleNames()->implode(' ,') }}</td>
                                <td> 
                                <a href="{!! route('user.edit', [$user->id]) !!}">Edit </a>&nbsp;&nbsp;
                                <a href="{!! route('user.destroy', [$user->id]) !!}">Delete</i>  </a>
                                </td>
                            </tr> 
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
