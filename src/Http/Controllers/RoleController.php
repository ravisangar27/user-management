<?php 

namespace Aucos\Permissionview\Http\Controllers;

use Illuminate\Http\Request; 
use Aucos\Permissionview\Http\Requests\Roles\CreateReqeust; 
use Spatie\Permission\Models\Role;
use Route; 
use Spatie\Permission\Models\Permission; 
use Aucos\Permissionview\Traits\PermissionUpdate;


class RoleController extends Controller
{
    use PermissionUpdate;
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
       $modelsActions = $this->updateModelActions();
    
        return view('Permissionview::roles.create', compact('modelsActions'));
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
              
                $key = str_replace('_', ' ', $key); 

                if(Permission::where('name', $key)->count() == 0){
                    Permission::create(['name' => $key]);
                }
             
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
    {   $modelsActions = $this->updateModelActions();
        return view('Permissionview::roles.edit', compact('role',  'modelsActions'));
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
        
        $role->update(['name' => $request->name]); 
        $role->permissions()->detach(); 
        $input = $request->all();

        foreach ($input as $key => $value) { 
            //  echo $key;
              echo '<br>';
              if (!($key == '_token' || $key == 'name' || $key === 'guard_name' || $key == '_method')) {
                
                  $key = str_replace('_', ' ', $key); 
  
                  if(Permission::where('name', $key)->count() == 0){
                      Permission::create(['name' => $key]);
                  }
               
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
