<?php 

namespace Aucos\Permissionview\Http\Controllers;

use Illuminate\Http\Request; 
use Aucos\Permissionview\Http\Requests\Roles\CreateReqeust; 
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission; 
use Aucos\Permissionview\Models\PermissionModel; 
use Aucos\Permissionview\Models\PermissionAction; 

class RoleController extends Controller
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
        $roles = Role::all();
        return view('Permissionview::roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        
        $permission = $this->permission; 
        $permissionActions = PermissionAction::all();
        $permissionModel = PermissionModel::all();

        return view('Permissionview::roles.create', compact('permissionActions', 'permissionModel', 'permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateReqeust $request)
    {
        
        $role = Role::create(['name' => $request->name]); 

        $input = $request->all();
     
        foreach ($input as $key => $value) { 
          //  echo $key;
           // echo '<br>';
            if (!($key == '_token' || $key == 'name' || $key === 'guard_name' || $key == '_method')) {
              
                $key = str_replace('_', '-', $key);
                $role->givePermissionTo($key);
               // $group_array[$key] = 1;
            }
        }

        return redirect()->route('role.show', [$role->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    { 
       
        return view('Permissionview::roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    { 
        $permission = $this->permission; 
        $permissionActions = PermissionAction::all();
        $permissionModel = PermissionModel::all(); 
        $users = $this->user::all();
        return view('Permissionview::roles.edit', compact('role',  'permissionActions', 'permissionModel', 'permission', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(CreateReqeust $request, Role $role)
    { 
        app()['cache']->forget('spatie.permission.cache');
        if(auth()->user()->roles()->where('name', 'super-admin')->count() !== 0){
            $role->update(['name' => $request->name]); 
        }
       
        $role->permissions()->detach(); 
        $input = $request->all();
        app()['cache']->forget('spatie.permission.cache'); 
        if($request->userIds != null){
            foreach($request->userIds as $userId){
                $user = $this->user::find($userId);
                if(!($user->hasRole($role->name))){
                    $user->assignRole($role->name); 
                }
            } 
        }
        app()['cache']->forget('spatie.permission.cache');
        foreach ($input as $key => $value) { 
          
              if (!($key == '_token' || $key == 'name' || $key === 'guard_name' || $key == '_method' || $key == 'userIds')) {
                
                  $key = str_replace('_', '-', $key); 
               
                  $role->givePermissionTo($key);
                 // $group_array[$key] = 1;
              }
          }
        return redirect()->route('role.show', [$role->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    { 
        $role->delete();

        return redirect()->route('role.index');
    }
}
