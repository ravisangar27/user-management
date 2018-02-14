<?php 

namespace Aucos\Permissionview\Http\Controllers;

use Aucos\Permissionview\Http\Requests\Roles\CreateReqeust;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Aucos\Permissionview\Models\PermissionModel;
use Aucos\Permissionview\Models\PermissionAction;

class RoleController extends Controller
{
    protected $permission;
    protected $user;

    public function __construct(Permission $permission)
    {
        $this->middleware('auth');
        $this->permission = $permission;
        $this->user = config('auth.providers.users.model');
    }

    public function index()
    {
        $roles = Role::where('name', '!=', 'super-admin')->paginate(config('permissionview.pagination'));

        return view('Permissionview::roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        app()['cache']->forget('spatie.permission.cache');
        $permission = $this->permission;
        $permissionActions = PermissionAction::all();
        $permissionModel = PermissionModel::all();

        return view('Permissionview::roles.create', compact('permissionActions', 'permissionModel', 'permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateReqeust $request)
    {
        $role = Role::create(['name' => $request->name]);

        $inputs = $request->all();

        collect($inputs)->except(['_token', 'name', 'guard_name', '_method'])
        ->each(function ($inputs, $key) use ($role) {
            $key = str_replace('_', '-', $key);
            $role->givePermissionTo($key);
        });

        return redirect()->route('role.show', [$role->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('Permissionview::roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permission = $this->permission;
        $permissionActions = PermissionAction::all();
        $permissionModel = PermissionModel::all();
        $users = $this->user::all();
        app()['cache']->forget('spatie.permission.cache');

        return view('Permissionview::roles.edit', compact('role', 'permissionActions', 'permissionModel', 'permission', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(CreateReqeust $request, Role $role)
    {
        if ($role->name == 'super-admin') {
            if (!optional(auth()->user())->hasRole('super-admin')) {
                return redirect()->route('role.index');
            }
        }

        app()['cache']->forget('spatie.permission.cache');
        if (optional(auth()->user())->hasRole('super-admin')) {
            $role->update(['name' => $request->name]);
        }

        $role->permissions()->detach();
        $inputs = $request->all();
        app()['cache']->forget('spatie.permission.cache');
        $assigningUser = [];
        $userOb = $this->user;
        if ($request->userIds != null) {
            $assigningUser = collect($request->userIds)->map(function ($userId) use ($userOb, $role) {
                $user = $userOb::find($userId);
                if (!($user->hasRole($role->name))) {
                    $user->assignRole($role->name);
                }

                return $userId;
            });
        }

        $this->user::all()->pluck('id')->diff(collect($assigningUser))->each(function ($userId, $key) use ($userOb, $role) {
            $user = $userOb::find($userId);
            if (($user->hasRole($role->name))) {
                $user->removeRole($role->name);
            }
        });

        app()['cache']->forget('spatie.permission.cache');

        collect($inputs)->except(['_token', 'name', 'guard_name', '_method', 'userIds'])
            ->each(function ($input, $key) use ($role) {
                $key = str_replace('_', '-', $key);
                $role->givePermissionTo($key);
            });

        return redirect()->route('role.show', [$role->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if ($role->name == 'super-admin') {
            return redirect()->route('role.index');
        }

        $role->delete();

        return redirect()->route('role.index');
    }
}
