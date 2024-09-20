<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminProfileUpdateRequest;
use App\Http\Requests\AdminUpdatePasswordRequest;
use App\Models\Admin;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        $user = Auth::guard('admin')->user();
        return view('admin.profile.index', compact('user'));
    }

    public function passwordUpdate(AdminUpdatePasswordRequest $request, string $id)
    {
        // 789456123 password
        // above 1st i save new password
        $admin = Admin::findOrFail($id);
        $admin->password = bcrypt($request->password);
        $admin->save();

        toast('Password Update Successfully', 'success')->width(400);

        return redirect()->back();
    }

    public function create() {}

    public function store(Request $request) {}

    public function show(string $id) {}

    public function edit(string $id) {}

    public function update(AdminProfileUpdateRequest $request, string $id)
    {
        //handle image
        $imagePath = $this->handleFileUpload($request, 'image', $request->old_image);

        $admin = Admin::findOrFail($id);
        $admin->image = !empty($imagePath) ? $imagePath : $request->old_image;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->save();

        // sweet alert
        // Alert::success('Success Title', 'Success Message');
        toast('Update Successfully', 'success')->width(400);


        return redirect()->back();
    }

    public function destroy(string $id) {}
}
