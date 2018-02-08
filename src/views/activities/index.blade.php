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
                            <th>User</th>   
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody> 
                        @foreach($activities as $activity)
                            <tr>
                                <td>{{  class_basename($activity->subject_type)  }}</td>    
                                <td>{{  $activity->description }}</td>
                                <td>{{  $activity->causer->email }}</td>
                                <td>{{  $activity->created_at }}</td> 
                                <td><a href="{!! route('activity.show', [$activity->id]) !!}" class='btn btn-primary'>Show</a></td>
                            </tr> 
                        @endforeach
                    </tbody>
                </table> 
                <div> 
                {{ $activities->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection