<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProvinceCreateRequest;
use App\Http\Requests\ProvinceUpdateRequest;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Province Index,admin'])->only(['index']);
        $this->middleware(['permission:Province Create,admin'])->only(['store']);
        $this->middleware(['permission:Province Update,admin'])->only(['update']);
        $this->middleware(['permission:Province Delete,admin'])->only('destroy');
    }

    public function index()
    {
        $provinces = Province::where('delete_status', 1)->get();
        return view('admin.province.index', compact('provinces'));
    }

    public function create() {}

    public function store(ProvinceCreateRequest $request)
    {
        $province = new Province();
        $province->code = $request->province_code;
        $province->province = $request->province;
        $province->save();

        toast('Province Added Successfully', 'success')->width(400);
        return redirect()->route('admin.province.index');
    }

    public function show(string $id) {}

    public function edit(string $id) {}

    public function update(ProvinceUpdateRequest $request, string $id)
    {
        $province = Province::findOrFail($id);
        $province->code = $request->province_code_update;
        $province->province = $request->province_update;
        $province->save();

        toast('Province Updated Successfully', 'success')->width(400);
        return redirect()->route('admin.province.index');
    }

    public function destroy(string $id)
    {
        try {
            $province = Province::findOrFail($id);
            $province->delete_status = 0;
            $province->save();

            return response(['status' => 'success', 'message' => 'Province Delete Successfully']);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}
