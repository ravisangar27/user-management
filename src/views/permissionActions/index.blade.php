@extends('Permissionview::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2"> 
            <br><br>
            <a class=" btn btn-success pull-right" href="{!! route('permissionAction.create') !!}">Add new permission action</a> 
            <br><br>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Display name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody> 
                        @foreach($permissionActions as $permissionAction)
                            <tr>
                                <td>{{  $permissionAction->name }}</td> 
                                <td>{{  $permissionAction->display_name }}</td>
                                <td> 
                                    <div class="row">
                                        <div class="col-md-2">
                                            <a href="{!! route('permissionAction.edit', [$permissionAction->id]) !!}" class='btn btn-primary'>Edit </a>&nbsp;&nbsp; 
                                        </div> 
                                        <div class="col-md-2">
                                            {{ Form::open(['method' => 'DELETE', 'route' => ['permissionAction.destroy', $permissionAction->id]]) }}
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
