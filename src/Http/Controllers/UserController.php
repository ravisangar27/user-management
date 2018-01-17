<?php 

namespace Aucos\Permissionview\Http\Controllers;

use Illuminate\Http\Request; 
use Aucos\Permissionview\Http\Requests\Users\CreateReqeust;
use Aucos\Permissionview\Http\Requests\Users\EditReqeust; 
use Aucos\Permissionview\Models\Action;
use Aucos\Permissionview\Models\Model; 
use Route; 
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;  
use Aucos\Permissionview\Models\PermissionModel; 
use Aucos\Permissionview\Models\PermissionAction; 

class UserController extends Controller
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
        $users = $this->user::all();
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
        
        $user = $this->user::create([
            'name' => $request->name, 
            'email' => $request->email,
            'password' => bcrypt($request->password),  
        ]); 

        $input = $request->all(); 
        if($request->roles != null){
            $user->assignRole($request->roles);
        }
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
    public function show($userId)
    { 
        $user = config('auth.providers.users.model')::find($userId);
        return view('Permissionview::users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit($userId) 
    {  
        $user = config('auth.providers.users.model')::find($userId);
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
    public function update(EditReqeust $request, $userId)
    { 
        app()['cache']->forget('spatie.permission.cache');
        $user = config('auth.providers.users.model')::find($userId);
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
    public function destroy($userId)
    {   
        $user = config('auth.providers.users.model')::find($userId);
        $user->delete();
        return redirect()->route('user.index');
    }
}
