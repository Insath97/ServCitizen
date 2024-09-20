<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DistrictCreateRequest;
use App\Http\Requests\DistrictUpdateRequest;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:District Index,admin'])->only(['index', 'filter']);
        $this->middleware(['permission:District Create,admin'])->only(['create', 'store', 'filter']);
        $this->middleware(['permission:District Update,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:District Delete,admin'])->only('destroy');
    }

    public function index()
    {
        $province = Province::where('delete_status', 1)->get();
        $distritcs = District::where('delete_status', 1)->get();
        return view('admin.District.index', compact('province', 'distritcs'));
    }

    public function create() {}

    public function store(DistrictCreateRequest $request)
    {
        $district = new District();
        $district->district = $request->district;
        $district->code = $request->district_code;
        $district->province_id = $request->province;
        $district->save();

        toast('District Created Successfully', 'success')->width(400);
        return redirect()->route('admin.district.index');
    }

    public function show(string $id) {}

    public function edit(string $id)
    {
        $province = Province::where('delete_status', 1)->get();
        $district = District::findOrFail($id);
        return view('admin.District.edit', compact('district', 'province'));
    }

    public function update(DistrictUpdateRequest $request, string $id)
    {
        $district = District::findOrFail($id);
        $district->district = $request->district_update;
        $district->code = $request->district_code_update;
        $district->province_id = $request->province_update;
        $district->save();

        toast('District Updated Successfully', 'success')->width(400);
        return redirect()->route('admin.district.index');
    }

    public function destroy(string $id)
    {
        try {

            $district = District::findOrFail($id);
            $district->delete_status = 0;
            $district->save();

            return response(['status' => 'success', 'message' => 'District Delete Successfully']);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    public function filter(Request $request)
    {
        $districts = District::where(['province_id' => $request->province_id, 'delete_status' => 1])->get();
        return response()->json($districts);
    }
}
