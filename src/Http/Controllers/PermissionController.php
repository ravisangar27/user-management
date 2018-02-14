<?php 

namespace Aucos\Permissionview\Http\Controllers;

use Aucos\Permissionview\Http\Requests\Permissions\CreateReqeust;
use Spatie\Permission\Models\Permission;
use Aucos\Permissionview\Models\PermissionModel;
use Aucos\Permissionview\Models\PermissionAction;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    protected $permission;
    protected $user;
    protected $role;

    public function __construct(Permission $permission, Role $role)
    {
        $this->middleware('auth');
        $this->permission = $permission;
        $this->user = config('auth.providers.users.model');
        $this->role = $role;
        app()['cache']->forget('spatie.permission.cache');
    }

    public function index()
    {
        $permission = $this->permission;

        $permissionActions = PermissionAction::all();
        $permissionModel = PermissionModel::all();

        return view('Permissionview::permissions.index', compact('permission', 'permissionActions', 'permissionModel'));
    }

    public function store(CreateReqeust $request)
    {
        $inputs = $request->all();

        app()['cache']->forget('spatie.permission.cache');
        $inputAllPermission = [];

        $permissionOb = $this->permission;

        $inputAllPermission = collect($inputs)->except(['_token', '_method'])
            ->map(function ($input, $permission) use ($permissionOb) {
                $permissionOb->firstOrCreate(['name' => $permission]);

                return $permission;
            });

        app()['cache']->forget('spatie.permission.cache');

        Permission::all()->pluck('name')->diff(collect($inputAllPermission))->each(function ($deletePermission) use ($permissionOb) {
            $permission = $permissionOb->where('name', $deletePermission)->first();
            $permission->delete();
        });

        return redirect()->route('permission.index');
    }

    public function show(Permission $permission)
    {
        return view('Permissionview::permissions.show', compact('permission'));
    }

    public function edit(Permission $permission)
    {
        $users = $this->user::all();
        $roles = Role::where('name', '!=', 'super-admin')->get();

        return view('Permissionview::permissions.edit', compact('permission', 'roles', 'users'));
    }

    public function update(CreateReqeust $request, Permission $permission)
    {
        app()['cache']->forget('spatie.permission.cache');
        $assigningUser = [];
        $userOb = $this->user;
        if ($request->userIds != null) {
            $assigningUser = collect($request->userIds)->map(function ($userId) use ($userOb, $permission) {
                $user = $userOb::find($userId);
                if (!($user->hasPermissionTo($permission->name))) {
                    $user->givePermissionTo($permission->name);
                }

                return $userId;
            });
        }

        $this->user::all()->pluck('id')->diff(collect($assigningUser))->each(function ($userId) use ($userOb, $permission) {
            $user = $userOb::find($userId);
            if (($user->hasPermissionTo($permission->name))) {
                $user->revokePermissionTo($permission->name);
            }
        });

        $assigningRole = [];
        $roleOb = $this->role;
        if ($request->roleIds != null) {
            $assigningRole = collect($request->roleIds)->map(function ($roleId) use ($roleOb, $permission) {
                $role = $roleOb->find($roleId);
                if (!($role->hasPermissionTo($permission->name))) {
                    $role->givePermissionTo($permission->name);
                }

                return $roleId;
            });
        }

        Role::all()->pluck('id')->diff(collect($assigningRole))->each(function ($roleId) use ($roleOb, $permission) {
            $role = $roleOb->find($roleId);
            if (($role->hasPermissionTo($permission->name))) {
                $role->revokePermissionTo($permission->name);
            }
        });

        return redirect()->route('permission.show', [$permission->id]);
    }
}
