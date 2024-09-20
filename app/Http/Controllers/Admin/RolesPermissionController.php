<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleCreateRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:User Role Index,admin'])->only(['index']);
        $this->middleware(['permission:User Role Create,admin'])->only(['create','store']);
        $this->middleware(['permission:User Role Update,admin'])->only(['edit','update']);
        $this->middleware(['permission:User Role Delete,admin'])->only('destroy');
    }

    public function index()
    {
        $roles = Role::all();
        return view('admin.role-permission.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy('group_name');
        return view('admin.role-permission.create', compact('permissions'));
    }

    public function store(RoleCreateRequest $request)
    {
        /*
            1st using artisan commands to create permissions
            php artisan permission:create-permission "edit articles" admin
        */

        /* 2nd create the role  */
        $role = Role::create(['guard_name' => 'admin', 'name' => $request->role_name]);

        /* 3rd assign permission to that particular role */
        $role->syncPermissions($request->permissions);

        toast('Role created and permissions assigned.', 'success')->width(400);
        return redirect()->route('admin.role.index');
    }

    public function edit(string $id)
    {
        $roles = Role::findOrFail($id);
        $permissions = Permission::all()->groupBy('group_name');

        $role_permission = $roles->permissions;
        $role_permission =   $role_permission->pluck('name')->toArray();

        return view('admin.role-permission.edit', compact('roles', 'permissions', 'role_permission'));
    }

    public function update(RoleCreateRequest $request, string $id)
    {
        $roles = Role::findOrFail($id);
        $roles->update(['guard_name' => 'admin', 'name' => $request->role_name]);
        $roles->syncPermissions($request->permissions);

        toast('Role & permissions Updated.', 'success')->width(400);
        return redirect()->route('admin.role.index');
    }

    public function destroy(string $id)
    {
        try {
            $roles = Role::findOrFail($id);
            if ($roles->name === 'Super Admin') {
                return response(['status' => 'error', 'message' => 'Can\'t Deleted This is Default Role']);
            }
            $roles->delete();
            return response(['status' => 'success', 'message' => 'Role & Permission Deleted Successfully']);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}
