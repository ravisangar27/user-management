<?php 

namespace Aucos\Permissionview\Http\Controllers;

use Illuminate\Http\Request; 
use Aucos\Permissionview\Http\Requests\Users\CreateReqeust; 
use Aucos\Permissionview\Models\Action;
use Aucos\Permissionview\Models\Model; 
use App\User;
use Route; 
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;  
use Aucos\Permissionview\Traits\PermissionUpdate;


class UserController extends Controller
{
    use PermissionUpdate;
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
        $modelsActions = $this->updateModelActions();
        return view('Permissionview::users.create', compact('modelsActions'));
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
        
            if (!($key == '_token' || $key == 'name' || $key === 'guard_name' || $key == '_method' || $key == 'roles' )) {
              
                $key = str_replace('_', ' ', $key); 

                if(Permission::where('name', $key)->count() == 0){
                    Permission::create(['name' => $key]);
                }
             
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
        $modelsActions = $this->updateModelActions();
         $roles = Role::all(); 
        // $str = 'HomeClientCome';
        // $pieces = preg_split('/(?=[A-Z])/',$str);
        // dd(strtolower(implode(array_filter($pieces), '-')));
      //  dd($user->permissions);
        return view('Permissionview::users.edit', compact('user',  'modelsActions', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(CreateReqeust $request, user $user)
    { 
        
        $user->update(['name' => $request->name]); 
        $user->permissions()->detach(); 
        $input = $request->all(); 
       // dd($input );
       // dd($input); 
       $user->roles()->detach();
       $user->assignRole($request->roles); 
       
        foreach ($input as $key => $value) { 
            //  echo $key;
              echo '<br>';
              if (!($key == '_token' || $key == 'name' || $key === 'password' ||  $key === 'confirm_password' || $key === 'email' || $key == '_method'||  $key == 'roles')) {
                
                  $key = str_replace('_', ' ', $key); 
  
                
               
                  $user->givePermissionTo($key);
                 // $group_array[$key] = 1;
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
