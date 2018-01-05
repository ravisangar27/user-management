<?php

namespace Aucos\Permissionview\Traits;
use Spatie\Permission\Models\Permission; 
use Route;

trait PermissionUpdate
{
    public function updateModelActions() {

        $routeCollection = Route::getRoutes(); 
        
        $model_array = array();
        $action_array = array();
        $model_action = array(); 
        $merge_action = config('permissionview.merge_action');

        foreach ($routeCollection as $route) { 
           
            $action_name = $route->getActionName();
            $at_pos = strpos($action_name, '@');
            if ($at_pos) {
                $model_name = class_basename(str_replace('Controller', '', substr($action_name, 0, $at_pos)));

                if(!($model_name =='Auth' || $model_name =='Password' || $model_name == 'Login' || $model_name == 'Register' || $model_name == 'ForgotPassword' ||  $model_name == 'ResetPassword' ) )
                { 
                    $action_name = substr($action_name, $at_pos + 1);
                    $model_array[] = $model_name; 
                    if(array_key_exists($action_name, $merge_action)){
                        $action_name = $merge_action[$action_name];
                    }
                    $action_array[] = $action_name;
                    $model_action[$model_name][] = $action_name; 
                    $permission = $model_name.' '.$action_name;
                    if(Permission::where('name', $permission)->count() == 0){
                        Permission::create(['name' => $permission]);
                    }
                }
            }
            $model_array = array_values(array_unique($model_array));
            $action_array = array_values(array_unique($action_array));
        } 
       
        $model_array = $this->displaySet($model_array);
        $action_array = $this->displaySet($action_array); 
        
        $modelActions = array();
        $modelActions['models'] = $model_array; 
        $modelActions['actions'] = $action_array;
        $modelActions['modelActions'] = $model_action; 
       // dd($modelActions);
        return $modelActions;
    } 

    private function displaySet($datas){ 
        $displaySetArray = array(); 
        $display_name = config('permissionview.display_name.'.config('permissionview.display_language')); 
  
        foreach($datas as $key => $data){
            $displaySetArray[$key]['name'] =$data; 

            if(array_key_exists($data, $display_name)){
                $data = $display_name[$data];
            }
            $displaySetArray[$key]['display_name'] = $data;
        } 

        return $displaySetArray;
    }
}