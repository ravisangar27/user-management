<?php 

namespace Aucos\Permissionview\Http\Controllers;

use Illuminate\Http\Request; 
use Aucos\Permissionview\Http\Requests\PermissionAction\CreateReqeust; 
use Route; 
use Spatie\Permission\Models\Permission; 
use Aucos\Permissionview\Models\PermissionAction; 


class PermissionActionController extends Controller
{

    public function index()
    {  
       $permissionActions = PermissionAction::all();
        return view('Permissionview::permissionActions.index', compact('permissionActions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   

        return view('Permissionview::permissionActions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(CreateReqeust $request)
    {   
        $permissionActionInput = array(
            'name' => $request->name,
            'display_name' => $request->display_name
        ); 

        if($request->has('permission_default')){
            $permissionActionInput['permission_default'] = true;
        }
        
        $permissionAction = PermissionAction::create($permissionActionInput);

       
        return redirect()->route('permissionAction.show', [$permissionAction->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show(PermissionAction $permissionAction)
    { 
       
        return view('Permissionview::permissionActions.show', compact('permissionAction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit(PermissionAction $permissionAction)
    {
        return view('Permissionview::permissionActions.edit', compact('permissionAction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(CreateReqeust $request, PermissionAction $permissionAction)
    { 
        $permissionActionInput = array(
            'name' => $request->name,
            'display_name' => $request->display_name
        ); 
        
        $permissionActionInput['permission_default'] = ($request->has('permission_default'))? true : false;

        $permissionAction->update($permissionActionInput); 
      
        return redirect()->route('permissionAction.show', [$permissionAction->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(PermissionAction $permissionAction)
    { 
        
        $permissionAction->delete();

        return redirect()->route('permissionAction.index');
    }
}
