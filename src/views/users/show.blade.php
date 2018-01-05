@extends('Permissionview::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2"> 
                <table>
                 
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ $user->email }}</td>
                        </tr> 
                        <tr>
                            <td>Permission</td>
                            <td>
                                @foreach($user->getDirectPermissions() as $permission)
                                    <div>{{ $permission->name }}</div>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>roles</td>
                            <td> <br><br>
                            {{  $user->getRoleNames()->implode(' ,') }} 
                                <br><br>
                                Permissions 
                                @foreach($user->getPermissionsViaRoles() as $permission)
                                    <div>{{ $permission->name }}</div>
                                @endforeach
                                
                            </td>
                        </tr>
                    </tbody> 
                </table>
            </div>
        </div>
    </div>
@endsection