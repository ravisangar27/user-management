<?php 

namespace Aucos\Permissionview\Http\Controllers;

use Spatie\Activitylog\Models\Activity as ActivityLog;

class ActivityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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
