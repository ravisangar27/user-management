<?php 

namespace Aucos\Permissionview\Http\Controllers;

use Illuminate\Http\Request; 
use Aucos\Permissionview\Http\Requests\PermissionAction\CreateReqeust; 
use Route; 
use Spatie\Permission\Models\Permission; 
use Aucos\Permissionview\Models\PermissionAction; 
use Spatie\Activitylog\Models\Activity as ActivityLog;

class ActivityController extends Controller
{

    public function index()
    {  
        $activities = ActivityLog::paginate(config('permissionview.pagination'));
        return view('Permissionview::activities.index', compact('activities'));
    }

    
    /**
     * Display the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show(ActivityLog $activity)
    { 
       
        return view('Permissionview::activities.show', compact('activity'));
    }

    
}
