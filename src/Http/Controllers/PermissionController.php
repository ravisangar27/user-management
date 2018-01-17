<?php 

namespace Aucos\Permissionview\Http\Controllers;

use Illuminate\Http\Request; 
use Aucos\Permissionview\Http\Requests\Permissions\CreateReqeust; 
use Route; 
use Spatie\Permission\Models\Permission; 
use Aucos\Permissionview\Models\PermissionModel; 
use Aucos\Permissionview\Models\PermissionAction; 
use Spatie\Permission\Models\Role; 

class PermissionController extends Controller
{
  
    protected $permission;
    protected $user;

    public function __construct(Permission $permission)
    {
       
        $this->permission = $permission;
        $this->user = config('auth.providers.users.model');
    }

    public function index()
    {  
        $permission = $this->permission; 

        $permissionActions = PermissionAction::all();
        $permissionModel = PermissionModel::all();
        
        return view('Permissionview::permissions.index', compact('permission', 'permissionActions', 'permissionModel'));
    }


    public function store(CreateReqeust $request)
    {
        
        $input = $request->all(); 
        $inputAllPermission = array();

        app()['cache']->forget('spatie.permission.cache');
        $inputAllPermission = array();
        foreach ($input as $permission => $value) { 
            if (!($permission == '_token' || $permission == '_method')) {
                $inputAllPermission[] = $permission; 
                if(Permission::where('name', $permission)->count() === 0){
                    Permission::create(['name' => $permission]);
                }
            }
        } 
        app()['cache']->forget('spatie.permission.cache');

        foreach( Permission::all()->pluck('name')->diff(collect($inputAllPermission)) as $deletePermission){
            $permission = Permission::where('name', $deletePermission)->first(); 
            $permission->delete();
         }

        return redirect()->route('permission.index');
    } 

   
    public function show(Permission $permission)
    { 
       
        return view('Permissionview::permissions.show', compact('permission'));
    } 

    public function edit(Permission $permission)
    { 
        $users = $this->user::all();
        $roles = Role::all();

        return view('Permissionview::permissions.edit', compact('permission', 'roles', 'users'));
    } 

    public function update(CreateReqeust $request, Permission $permission)
    { 
        
        app()['cache']->forget('spatie.permission.cache');
        $assigningUser = array();
       
        if($request->userIds != null){
            foreach($request->userIds as $userId){ 
                $assigningUser[] = $userId;
                $user = $this->user::find($userId);
                if(!($user->hasPermissionTo($permission->name))){
                    $user->givePermissionTo($permission->name); 
                }
            } 
        } 
       
        foreach( $this->user::all()->pluck('id')->diff(collect($assigningUser)) as $userId){
            $user = $this->user::find($userId); 
            if(($user->hasPermissionTo($permission->name))){
                $user->revokePermissionTo($permission->name); 
            }
         }

         $assigningRole = array();
        if($request->roleIds != null){
            foreach($request->roleIds as $roleId){ 
                $assigningRole[] = $roleId;
                $role = Role::find($roleId);
                if(!($role->hasPermissionTo($permission->name))){
                    $role->givePermissionTo($permission->name); 
                }
            } 
        } 


        foreach( Role::all()->pluck('id')->diff(collect($assigningRole)) as $roleId){
            $role = Role::find($roleId); 
            if(($role->hasPermissionTo($permission->name))){
                $role->revokePermissionTo($permission->name); 
            }
         } 

        return redirect()->route('permission.show', [$permission->id]);
    }
}
