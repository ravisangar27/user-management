<?php 

namespace Aucos\Permissionview\Http\Controllers;

use Illuminate\Http\Request; 
use Aucos\Permissionview\Http\Requests\Permissions\CreateReqeust; 
use Route; 
use Spatie\Permission\Models\Permission; 
use Aucos\Permissionview\Models\PermissionModel; 
use Aucos\Permissionview\Models\PermissionAction; 

class PermissionController extends Controller
{
  
    protected $permission;

    public function __construct(Permission $permission)
    {
       
        $this->permission = $permission;
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
}
