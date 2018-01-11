<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission; 
use Spatie\Permission\Models\Role;
use App\User;
use Aucos\Permissionview\Models\PermissionModel; 
use Aucos\Permissionview\Models\PermissionAction; 

class PermissionViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        
        $tableNames = config('permissionview.table_names'); 
        
        $permissionBasicActions = array(
            'index' => 'Übersicht', 
            'show' => 'Details', 
            'create' => 'Erstellen', 
            'update' => 'Bearbeiten', 
            'delete' => 'Löschen', 
            'restore' => 'Wiederherstellen'
        ); 

        foreach($permissionBasicActions as $name => $displayName ){ 
            
            PermissionAction::create([
                'name' => $name,
                'display_name' =>  $displayName,
                'permission_default' => true
            ]);
        } 

        $packageModels = array(
            'user' => 'User', 
            'role' => 'Role', 
            'permission-action' => 'Permission Action',
            'permission-model' => 'Permission Model',
            'permission' => 'Permission'
        ); 

        foreach($packageModels as $modelName => $ModelDisplayName ){

            PermissionModel::create([
                'name' =>  $modelName,
                'display_name' =>  $ModelDisplayName
            ]);

            if($modelName == 'permission'){
                $permissionBasicActions = array(
                    'index' => 'Übersicht', 
                    'update' => 'Bearbeiten'
                ); 
            } 
            foreach($permissionBasicActions as $actionName => $ActionDisplayName ){ 
                 $permission = $modelName.'-'.$actionName;
                if(Permission::where('name', $permission)->count() === 0){
                    Permission::create(['name' => $permission]);
                }
            }
        } 

        if(Role::where('name', 'super-admin')->count() === 0){
            Permission::create(['name' => 'super-admin']);
        }

        $configUser = config('permissionview.user'); 

        if($configUser['status']){
            $user = User::create([
                'name' => $configUser['name'], 
                'email' => $configUser['email'],
                'password' => bcrypt($configUser['password']),  
            ]);
            $user->assignRole('super-admin');
        }
    }
}