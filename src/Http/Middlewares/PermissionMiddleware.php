<?php
namespace Aucos\Permissionview\Http\Middlewares;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PermissionMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    { 
    //    dd(2);
        if (app('auth')->guest()) {
            throw UnauthorizedException::notLoggedIn();
        } 

        $routeAction = explode('@', class_basename($request->route()->getAction()['controller']));
        $route = $request->route();
        $parameters = $route->parameters();

        $loggedUser = $request->user(); 
        $model_name =  $permissions = str_replace('Controller', '', $routeAction[0]); 
        $action_name =  $routeAction[1]; 
        $merge_action = config('permissionview.merge_action'); 
        if(array_key_exists($action_name, $merge_action)){
            $action_name = $merge_action[$action_name];
        } 

        $model_pieces = preg_split('/(?=[A-Z])/', $model_name);
        $model_name = strtolower(implode(array_filter($model_pieces), '-'));
        
        $permissions =  $model_name . '-' . $action_name;
        
        if ($permissions == 'home-index') {
            
            return $next($request);
        }
    
        if ($loggedUser->hasPermissionTo($permissions)) {
            
            return $next($request);
        }
        dd('you do not  have permission for this request');
        echo 'you do not  have permission for this request';
        return redirect('/home');

        
    }
}