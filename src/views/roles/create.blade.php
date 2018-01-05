@extends('Permissionview::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
               
                    {!! Form::open(['route' => 'role.store']) !!}

                        @include ('Permissionview::roles.form') 

                       
                                <table class="table table-striped table-header-rotated">
                                    <thead> 
                                        <tr> 
                                            <th></th>
                                            @foreach($modelsActions['actions'] as $action)
                                            <th><div class="rotate-45"><span>{!! $action['display_name'] !!}</span></div></th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($modelsActions['models'] as $model)
                                        <tr>
                                            <td>{!! $model['display_name'] !!}</td>
                                            @foreach($modelsActions['actions'] as $action)
                                            <td>
                                                @if(array_search($action['name'], $modelsActions['modelActions'][$model['name']]) || array_search($action['name'], $modelsActions['modelActions'][$model['name']]) === 0 )    
                                               
                                                {!! Form::checkbox($model['name'].'.'.$action['name']), '' !!}
                                               
                                                @endif
                                            </td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>  
                          

                        {!! Form::submit('add', array('class' => 'btn btn-primary')) !!}

                    {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection