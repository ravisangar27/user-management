@extends('Permissionview::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2"> 
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
                            <td>{{ $role->name }}</td>
                        </tr>
                        <tr>
                            <td>Guard name</td>
                            <td>{{ $role->guard_name }}</td>
                        </tr>
                    </tbody> 
                </table>
            </div>
        </div>
    </div>
@endsection