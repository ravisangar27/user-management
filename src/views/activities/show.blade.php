@extends('Permissionview::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12"> 
                <div>
                
                    <ol class="breadcrumb">
                        <li><a href="{!! route('activity.index') !!}">Activity</a></li> 
                        <li><b>Activity show </b></li>
                    </ol>
                </div> 
                <br><br>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>User</td>
                            <td>{{ $activity->causer->email }}</td>
                        </tr>
                        <tr>
                            <td>Model name</td>
                            <td>{{  class_basename($activity->subject)  }}</td>
                        </tr>
                        <tr>
                            <td>Time</td>
                            <td>{{  $activity->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Subject</td>
                            <td> 
                                @if($activity->subject != null)
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(collect($activity->subject->getAttributes())->except(['id', 'created_at', 'updated_at', 'deleted_at']) as $name => $value)
                                            <tr>
                                                <td>{!! $name !!}</td>
                                                <td>{!! $value !!}</td>
                                            </tr>
                                        @endforeach 
                                    </tbody> 
                                </table>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td> {{ $activity->description }} </td>
                        </tr>
                     
                        <tr>
                            <td>Changes</td>
                            <td> 
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Attributes</th>
                                            @if(array_key_exists('old', $activity->changes()->toArray()))
                                            <th>Old</th>
                                            @endif  
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($activity->changes()['attributes'] as $key => $value)
                                            <tr>
                                                <td>{!! $key !!}</td>
                                                <td>{!! $value !!}</td>
                                                @if(array_key_exists('old', $activity->changes()->toArray()))
                                                <td>{!! $activity->changes()['old'][$key] !!}</td>
                                                @endif  
                                            </tr>
                                        @endforeach 
                                    </tbody> 
                                </table>
                            </td>
                        </tr>
                         
                    </tbody> 
                </table>
            </div>
        </div>
    </div>
@endsection