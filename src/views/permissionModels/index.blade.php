@extends('Permissionview::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2"> 
            <br><br>
            <a class=" btn btn-success pull-right" href="{!! route('permissionModel.create') !!}">Add new permission model</a> 
            <br><br>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Display name</th>
                            <th width="180px">Action</th>
                        </tr>
                    </thead>
                    <tbody> 
                        @foreach($permissionModels as $permissionModel)
                            <tr>
                                <td>{{  $permissionModel->name }}</td> 
                                <td>{{  $permissionModel->display_name }}</td>
                                <td> 
                                    <div class="row">
                                        <div class="col-md-6 text-left">
                                            <a href="{!! route('permissionModel.edit', [$permissionModel->id]) !!}" class='btn btn-primary'>Edit </a>&nbsp;&nbsp; 
                                        </div> 
                                        <div class="col-md-6 text-right">
                                            {{ Form::open(['method' => 'DELETE', 'route' => ['permissionModel.destroy', $permissionModel->id]]) }}
                                                {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                                            {{ Form::close() }}
                                        </div>
                                    </div> 
                                </td>
                            </tr> 
                        @endforeach
                    </tbody>
                </table> 
                <div> 
                {{ $permissionModels->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
