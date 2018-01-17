@extends('Permissionview::layouts.master')

@section('content')
    <div class="container"> 
        <div class="row">
            <div class="col-md-12"> 
            @role('super-admin')
                <div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#permission-view" aria-controls="permission-view" role="tab" data-toggle="tab">Permission view</a></li>
                        <li role="presentation"><a href="#permission-update" aria-controls="permission-update" role="tab" data-toggle="tab">Permission update</a></li>
                    
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="permission-view">
                        @include ('Permissionview::permissions.view') 
                        </div>
                        <div role="tabpanel" class="tab-pane" id="permission-update">
                        {!! Form::open(['route' => 'permission.store']) !!}
                            <table class="table table-striped table-header-rotated">
                                <thead> 
                                    <tr> 
                                        <th></th>
                                        @foreach($permissionActions as $action)
                                        <th><div class="rotate-45"><span>{!! $action['display_name'] !!}</span></div></th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                
                                    @foreach($permissionModel as $model)
                                    <tr>
                                        <td>{!! $model['display_name'] !!}</td>
                                        @foreach($permissionActions as $action)
                                        <td>
                                            @if($permission->where('name', $model['name'].'-'.$action['name'])->count())
                                                {!! Form::checkbox($model['name'].'-'.$action['name'] ,1  , true) !!}
                                            @else
                                                {!! Form::checkbox($model['name'].'-'.$action['name']), '' !!}
                                            @endif
                                        </td> 

                                        @endforeach
                                    </tr>
                                    @endforeach 
                                
                                </tbody> 
                            
                            </table>  
                            {!! Form::submit('Update', array('class' => 'btn btn-primary')) !!}
                                {!! Form::close() !!}
                        </div>
                    </div>
                </div> 
                @else
                    @include ('Permissionview::permissions.view') 
                @endrole
            </div>
        </div>
    </div>
@endsection
