<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission; 

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
            DB::table($tableNames['permissionAction'])->insert([
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

            DB::table($tableNames['permissionModel'])->insert([
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
     
    }
}