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
    protected $userName;
    
    public function __construct(Permission $permission)
    {  
        $this->permission = $permission;
        $this->user = config('auth.providers.users.model');
        $this->userName = config('permissionview.user.userName');
        
    }

    public function index()
    { 
        $users = $this->user::paginate(config('permissionview.pagination'));
        $userName = $this->userName;
        return view('Permissionview::users.index', compact('users', 'userName'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        app()['cache']->forget('spatie.permission.cache');
        if(optional(auth()->user())->hasRole('super-admin')){
            $roles = Role::all();
        } else {
            $roles = Role::where('name', '!=' , 'super-admin' )->get();
        }
        $permission = $this->permission; 
        $permissionActions = PermissionAction::all();
        $permissionModel = PermissionModel::all();
        $userName = $this->userName;
        return view('Permissionview::users.create', compact('permissionActions', 'permissionModel', 'roles', 'permission', 'userName'));
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
            $this->userName => $request->name, 
            'email' => $request->email,
            'password' => bcrypt($request->password),  
        ]); 

        $inputs = $request->all();

        if($request->roles != null){ 
            $roles = $request->roles;
            if(! optional(auth()->user())->hasRole('super-admin')){
                $roles = collect($roles)->filter(function ($value, $key) {
                    return $value != 'super-admin';
                });
            }
            $user->assignRole($roles); 
        } 
        
        collect($inputs)->except(['_token', 'name', 'password', 'password_confirmation', 'email', '_method', 'roles'])
            ->each(function ($input, $key) use ($user) {
                $key = str_replace('_', '-', $key); 
                $user->givePermissionTo($key);
            });
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
        $userName = $this->userName;
        return view('Permissionview::users.show', compact('user', 'userName'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit($userId) 
    {   
        app()['cache']->forget('spatie.permission.cache');
        $user = config('auth.providers.users.model')::find($userId);
        if(optional(auth()->user())->hasRole('super-admin')){
            $roles = Role::all();
        } else { 

            $roles = Role::where('name', '!=' , 'super-admin' )->get();
        }
        $permission = $this->permission; 
        $permissionActions = PermissionAction::all();
        $permissionModel = PermissionModel::all(); 
        $userName = $this->userName;
        return view('Permissionview::users.edit', compact('user',  'permissionActions', 'permissionModel', 'roles', 'permission', 'userName'));
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
        $user->update([$this->userName => $request->name]); 
        $user->permissions()->detach(); 
        $inputs = $request->all(); 
        $user->roles()->detach();
        app()['cache']->forget('spatie.permission.cache'); 
       
        if($request->roles != null){ 
            $roles = $request->roles;
            if(! optional(auth()->user())->hasRole('super-admin')){

                $roles = collect($roles)->filter(function ($value, $key) {
                    return $value != 'super-admin';
                });
            } 
            $user->assignRole($roles); 
        }
        
        collect($inputs)->except(['_token', 'name', 'password', 'confirm_password', 'email', '_method', 'roles'])->each(function ($input, $key) use ($user) {
            $key = str_replace('_', '-', $key); 
            $user->givePermissionTo($key);
        });
     
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

    public function log($userId) 
    {  
        $user = config('auth.providers.users.model')::find($userId);
        $userLogs =  $user->activity()->paginate(config('permissionview.pagination'));
        return view('Permissionview::users.log', compact('userLogs'));
    }
}
