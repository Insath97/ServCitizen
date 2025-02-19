<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUserCreateRequest;
use App\Http\Requests\AdminUserUpdateRequest;
use App\Mail\UserRoleCreateMail;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:User Role Index,admin'])->only(['index']);
        $this->middleware(['permission:User Role Create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:User Role Update,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:User Role Delete,admin'])->only('destroy');
    }

    public function index()
    {
        $users = Admin::all();
        return view('admin.user-role.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.user-role.create', compact('roles'));
    }

    public function store(AdminUserCreateRequest $request)
    {
        try {
            $user = new Admin();

            $user->name = $request->user_name;
            $user->image = '/user image';
            $user->email = $request->user_email;
            $user->password = bcrypt($request->password);
            $user->status = 1;

            $user->save();

            /* assign the role for user */
            $user->assignRole($request->role);

            /* sending credentials via mail */
            Mail::to($request->user_email)->send(new UserRoleCreateMail($request->user_email, $request->password, $request->role));

            toast('User created Successfully', 'success')->width(400);
            return redirect()->route('admin.user-role.index');
        } catch (\Throwable $th) {
            toast(__($th->getMessage()), 'error')->width(400);
            return redirect()->route('admin.user-role.index');
        }
    }

    public function show(string $id) {}

    public function edit(string $id)
    {
        $users = Admin::findOrFail($id);
        $roles = Role::all();
        return view('admin.user-role.edit', compact('users', 'roles'));
    }

    public function update(AdminUserUpdateRequest $request, string $id)
    {
        if ($request->has('password') && !empty($request->password)) {
            $request->validate([
                'password' => ['confirmed', 'min:8']
            ]);
        }
        $user = Admin::findOrFail($id);

        $user->name = $request->user_name;
        $user->image = '/user image';
        $user->email = $request->user_email;
        $user->status = 1;

        if ($request->has('password') && !empty($request->password)) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        /* assign the role for user  syncRoles => remove current and replaced new role*/
        $user->syncRoles($request->role);

        toast('User Updated Successfully', 'success')->width(400);
        return redirect()->route('admin.user-role.index');
    }

    public function destroy(string $id)
    {
        try {
            $user = Admin::findOrFail($id);

            /* super admin validation */
            if ($user->getRoleNames()->first() === 'Super Admin') {
                return response(['status' => 'error', 'message' => 'Can\'t Deleted This is Default Role']);
            }
            $user->delete();

            return response(['status' => 'success', 'message' => 'User Deleted Successfully']);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}
