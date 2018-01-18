@extends('Permissionview::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2"> 
                <div>
                
                    <ol class="breadcrumb">
                        <li><a href="{!! route('permissionModel.index') !!}">permissionModel</a></li> 
                        <li><b>permissionModel show </b></li>
                    </ol>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td>
                                {{ $permissionModel->name }}
                            </td>
                        </tr>
                        <tr>
                            <td>Guard name</td>
                            <td>
                                {{ $permissionModel->guard_name }}
                            </td>
                        </tr>
                    </tbody> 
                </table>
            </div>
        </div>
    </div>
@endsection