@extends('Permissionview::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2"> 
                <a class=" btn btn-success pull-right" href="{!! route('role.create') !!}">Add new role</a> 
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody> 
                        @foreach($roles as $role)
                            <tr>
                                <td>{{  $role->name }}</td> 
                                <td> 
                               
                                <div class="row">
                                    <div class="col-md-2">
                                        <a href="{!! route('role.edit', [$role->id]) !!}" class='btn btn-primary'>Edit </a>&nbsp;&nbsp; 
                                    </div> 
                                    <div class="col-md-2">
                                        {{ Form::open(['method' => 'DELETE', 'route' => ['role.destroy', $role->id]]) }}
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
