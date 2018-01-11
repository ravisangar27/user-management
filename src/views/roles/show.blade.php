@extends('Permissionview::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2"> 
                <div>
                
                    <ol class="breadcrumb">
                        <li><a href="{!! route('role.index') !!}">Role</a></li> 
                        <li><b>Role show </b></li>
                    </ol>
                </div> 
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td>{{ $role->name }}</td>
                        </tr>
                        <tr>
                            <td>Guard name</td>
                            <td>
                                <div class="row">
                                @foreach($role->permissions as $permission ) 
    
                                    <div class="col-md-3" style="color:{!! '#'.dechex(rand(0x000000, 0xFFFFFF)) !!}">{!! $permission->name !!}</div> 
                                   
                                @endforeach 
                                </div>
                            </td>
                        </tr>
                    </tbody> 
                </table>
            </div>
        </div>
    </div>
@endsection