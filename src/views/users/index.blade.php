@extends('Permissionview::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2"> 
            <a class=" btn btn-success pull-right" href="{!! route('user.create') !!}">Add new user</a> 
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
                                <td>  <a href="{!! route('user.show', [$user->id]) !!}" > {{  $user->name }}  </a> </td> 
                                <td>{{  $user->email }}</td> 
                                <td>{{  $user->getRoleNames()->implode(' ,') }}</td>
                                <td> 
                                    <div class="row">
                                        <div class="col-md-3">
                                            <a href="{!! route('user.edit', [$user->id]) !!}" class='btn btn-primary'>Edit </a>&nbsp;&nbsp; 
                                        </div> 
                                        <div class="col-md-3">
                                            {{ Form::open(['method' => 'DELETE', 'route' => ['user.destroy', $user->id]]) }}
                                                {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                                            {{ Form::close() }}
                                        </div>
                                    </div> 
                                </td>
                            </tr> 
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
