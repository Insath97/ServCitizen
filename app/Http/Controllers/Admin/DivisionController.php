<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DivisionCreateRequest;
use App\Http\Requests\DivisionUpdateRequest;
use App\Models\District;
use App\Models\Division;
use App\Models\Province;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:DS Index,admin'])->only(['index', 'filter']);
        $this->middleware(['permission:DS Create,admin'])->only(['store', 'filter']);
        $this->middleware(['permission:DS Update,admin'])->only(['edit', 'update', 'filter']);
        $this->middleware(['permission:DS Delete,admin'])->only('destroy');
    }

    public function index()
    {
        $province = Province::where('delete_status', 1)->get();
        $districts = District::where('delete_status', 1)->get();
        $division = Division::where('delete_status', 1)->get();
        return view('admin.divisional_secretariats.index', compact('division', 'districts', 'province'));
    }

    public function create() {}

    public function store(DivisionCreateRequest $request)
    {
        $division = new Division();
        $division->code = $request->ds_code;
        $division->name = $request->ds_name;
        $division->district_id = $request->district;
        $division->address = $request->address;
        $division->telephone = $request->telephone;
        $division->fax = $request->fax;
        $division->email = $request->email;
        $division->ds_officer = $request->ds_officer;
        $division->save();

        toast('District Created Successfully', 'success')->width(400);
        return redirect()->route('admin.division.index');
    }

    public function show(string $id) {}

    public function edit(string $id) {}

    public function update(DivisionUpdateRequest $request, string $id)
    {
        $division = Division::findOrFail($id);
        $division->code = $request->ds_code_update;
        $division->name = $request->ds_name_update;
        $division->district_id = $request->district_update;
        $division->address = $request->address_update;
        $division->telephone = $request->telephone_update;
        $division->fax = $request->fax_update;
        $division->email = $request->email_update;
        $division->ds_officer = $request->ds_officer_update;
        $division->save();

        toast('District Updated Successfully', 'success')->width(400);
        return redirect()->route('admin.division.index');
    }

    public function destroy(string $id)
    {
        try {
            $division = Division::findOrFail($id);
            $division->delete_status = 0;
            $division->save();

            return response(['status' => 'success', 'message' => 'Divisional Secretariat Delete Successfully']);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    public function filter(Request $request)
    {
        $districts_filter = Division::with('district')->where(['district_id' => $request->district_id_filter, 'delete_status' => 1])->get();
        return response()->json($districts_filter);
    }
}
