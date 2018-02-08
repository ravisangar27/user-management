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
        
        $permissionBasicActions = [
            'index' => 'Übersicht', 
            'show' => 'Details', 
            'create' => 'Erstellen', 
            'update' => 'Bearbeiten', 
            'delete' => 'Löschen', 
            'restore' => 'Wiederherstellen'
        ]; 

        foreach($permissionBasicActions as $name => $displayName ){ 

            PermissionAction::firstOrCreate([
                'name' => $name,
                'display_name' =>  $displayName,
                'permission_default' => true
            ]);
        } 

        Role::firstOrCreate(['name' => 'super-admin']);
      
        $permissionBasicActions = ['index', 'show', 'create', 'update', 'delete', 'restore'];
        $otherAction = '';
        $modelName = [];
        foreach (Permission::orderBy('name', 'asc')->get() as $permission) {
             $otherActionStatus = true;
            foreach ($permissionBasicActions as $permissionBasicAction) {
                if (str_is('*-'.$permissionBasicAction, $permission->name)) {
                    $modelName =  explode('-'.$permissionBasicAction, $permission->name);
                    PermissionModel::firstOrCreate([
                        'name' =>  $modelName[0],
                        'display_name' =>  $modelName[0]
                    ]);
                     $otherActionStatus = false;
                }
            }
            if ($otherActionStatus) {
                $otherAction = $permission->name;
            }
            // echo $permission->name.'<br>';
            if ($otherAction != '' && count($modelName)) {
                if (str_is($modelName[0].'-*', $otherAction)) {
                    $actionName =  explode($modelName[0].'-', $otherAction);
                    PermissionAction::firstOrCreate([
                        'name' => $actionName[1],
                        'display_name' =>  $actionName[1],
                        'permission_default' => false
                    ]);
                   
                }
            }
        } 

        $configUser = config('permissionview.user'); 

        if($configUser['email'] != '' && $configUser['password'] != ''){ 
            $userInput = [
                'email' => $configUser['email'],
                'password' => bcrypt($configUser['password']),  
            ];
            foreach($configUser['additional_fields'] as $additional_field) { 
                if($additional_field['name'] != '' && $additional_field['value'] != ''){ 
                    $userInput[$additional_field['name']] = $additional_field['value'];
                }
            }
            $user = config('auth.providers.users.model')::firstOrCreate($userInput);
            
    
            $user = config('auth.providers.users.model')::where('email', $configUser['email'])->first();
            if(!($user->hasRole('super-admin'))){
                    $user->assignRole('super-admin');
            } 
        } 
    }
}