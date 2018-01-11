<?php 

namespace Aucos\Permissionview\Http\Controllers;

use Illuminate\Http\Request; 
use Aucos\Permissionview\Http\Requests\Users\CreateReqeust;
use Aucos\Permissionview\Http\Requests\Users\EditReqeust; 
use Aucos\Permissionview\Models\Action;
use Aucos\Permissionview\Models\Model; 
use App\User;
use Route; 
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;  
use Aucos\Permissionview\Models\PermissionModel; 
use Aucos\Permissionview\Models\PermissionAction; 

class UserController extends Controller
{ 

    protected $permission;
    
    public function __construct(Permission $permission)
    {
           
        $this->permission = $permission;
    }

    public function index()
    { 
        $users = User::all();
        return view('Permissionview::users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
       
        $roles = Role::all();  
        $permission = $this->permission; 
        $permissionActions = PermissionAction::all();
        $permissionModel = PermissionModel::all();

        return view('Permissionview::users.create', compact('permissionActions', 'permissionModel', 'roles', 'permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateReqeust $request)
    {
        
        $user = User::create([
            'name' => $request->name, 
            'email' => $request->email,
            'password' => bcrypt($request->password),  
        ]); 

        $input = $request->all(); 
        $user->assignRole($request->roles);
     
        foreach ($input as $key => $value) { 
        
            if (!($key == '_token' || $key == 'name' || $key === 'email' || $key === 'password' || $key === 'password_confirmation' || $key == '_method' || $key == 'roles' )) {
              
             
                $user->givePermissionTo($key);
            }
        }

        return redirect()->route('user.show', [$user->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show(user $user)
    { 
       
        return view('Permissionview::users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit(user $user) 
    {  
      
        $roles = Role::all(); 
        $permission = $this->permission; 
        $permissionActions = PermissionAction::all();
        $permissionModel = PermissionModel::all();
        return view('Permissionview::users.edit', compact('user',  'permissionActions', 'permissionModel', 'roles', 'permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(EditReqeust $request, user $user)
    { 
        app()['cache']->forget('spatie.permission.cache');
        $user->update(['name' => $request->name]); 
        $user->permissions()->detach(); 
        $input = $request->all(); 
        $user->roles()->detach();
        app()['cache']->forget('spatie.permission.cache');
        if($request->roles != null){
            $user->assignRole($request->roles); 
        }
       
        foreach ($input as $key => $value) { 
       
              if (!($key == '_token' || $key == 'name' || $key === 'password' ||  $key === 'confirm_password' || $key === 'email' || $key == '_method'||  $key == 'roles')) {
                  $key = str_replace('_', '-', $key); 
                  $user->givePermissionTo($key);
              }
          }
        return redirect()->route('user.show', [$user->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(user $user)
    {
        $user->delete();
        return redirect()->route('user.index');
    }
}
