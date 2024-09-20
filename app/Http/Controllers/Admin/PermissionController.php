<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionCreateRequst;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Permission Index,admin'])->only(['index']);
        $this->middleware(['permission:Permission Create,admin'])->only(['store']);
        $this->middleware(['permission:Permission Update,admin'])->only(['update']);
        $this->middleware(['permission:Permission Delete,admin'])->only('destroy');
    }

    public function index()
    {
        $permissions = Permission::orderBy('id', 'desc')->get();
        return view('admin.permission.index', compact('permissions'));
    }

    public function create() {}

    public function store(PermissionCreateRequst $request)
    {
        $permission = new Permission();
        $permission->group_name = $request->permission_group;
        $permission->name = $request->permission;
        $permission->guard_name = 'admin';
        $permission->save();

        toast('Permission Created Successfully', 'success')->width(400);
        return redirect()->route('admin.permission.index');
    }

    public function show(string $id) {}

    public function edit(string $id) {}

    public function update(Request $request, string $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->group_name = $request->permission_group_update;
        $permission->name = $request->permission_update;
        $permission->guard_name = 'admin';
        $permission->save();

        toast('Permission Update Successfully', 'success')->width(400);
        return redirect()->route('admin.permission.index');
    }

    public function destroy(string $id)
    {
        try {

            $permission = Permission::findOrFail($id);
            $permission->delete();

            return response(['status' => 'success', 'message' => 'Permission Delete Successfully']);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}
