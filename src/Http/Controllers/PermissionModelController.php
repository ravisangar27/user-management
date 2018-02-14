<?php 

namespace Aucos\Permissionview\Http\Controllers;

use Aucos\Permissionview\Http\Requests\PermissionModel\CreateReqeust;
use Spatie\Permission\Models\Permission;
use Aucos\Permissionview\Models\PermissionModel;
use Aucos\Permissionview\Models\PermissionAction;

class PermissionModelController extends Controller
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
        $permissionModels = PermissionModel::paginate(config('permissionview.pagination'));

        return view('Permissionview::permissionModels.index', compact('permissionModels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Permissionview::permissionModels.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateReqeust $request)
    {
        $permissionModel = PermissionModel::create(['name' => $request->name,  'display_name' => $request->display_name]);

        $permissionBasicActions = PermissionAction::where('permission_default', true)->get()->pluck('name');
        //$permissionBasicActions = array('index' , 'show', 'create', 'update', 'delete' , 'restore');
        foreach ($permissionBasicActions as $permissionBasicAction) {
            $permission = $permissionModel->name . '-' . $permissionBasicAction;
            if (Permission::where('name', $permission)->count() === 0) {
                Permission::create(['name' => $permission]);
            }
        }

        return redirect()->route('permissionModel.show', [$permissionModel->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show(PermissionModel $permissionModel)
    {
        return view('Permissionview::permissionModels.show', compact('permissionModel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit(PermissionModel $permissionModel)
    {
        return view('Permissionview::permissionModels.edit', compact('permissionModel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(CreateReqeust $request, PermissionModel $permissionModel)
    {
        $permissionModel->update(['name' => $request->name, 'display_name' => $request->display_name]);

        return redirect()->route('permissionModel.show', [$permissionModel->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(PermissionModel $permissionModel)
    {
        $permissionModel->delete();

        return redirect()->route('permissionModel.index');
    }
}
