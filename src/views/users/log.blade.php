@extends('Permissionview::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2"> 
                <table class="table table-striped">
                    <thead>
                        <tr>   
                            <th>Model name</th>
                            <th>Description</th> 
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody> 
                        @foreach($userLogs as $userLog)
                            <tr>
                                <td>{{ class_basename($userLog->subject) }}</td>
                                <td>{{  $userLog->description }}</td> 
                                <td>{{  $userLog->created_at }}</td>
                                <td><a href="{!! route('activity.show', [$userLog->id]) !!}" class='btn btn-primary'>Show</a></td>
                            </tr> 
                        @endforeach
                    </tbody>
                </table> 
                <div> 
                {{ $userLogs->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection