<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GNDivisionCreateRequest;
use App\Models\District;
use App\Models\Division;
use App\Models\GNDivision;
use App\Models\Province;
use Illuminate\Http\Request;

class GNDivisionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:GN Division Index,admin'])->only(['index', 'filter']);
        $this->middleware(['permission:GN Division Create,admin'])->only(['store', 'filter']);
        $this->middleware(['permission:GN Division Update,admin'])->only(['edit', 'update', 'filter']);
        $this->middleware(['permission:GN Division Delete,admin'])->only('destroy');
    }

    public function index()
    {
        $province = Province::where('delete_status', 1)->get();
        $districts = District::where('delete_status', 1)->get();
        $division = Division::where('delete_status', 1)->get();
        $gn_divisions = GNDivision::where('delete_status', 1)->get();
        return view('admin.gn-division.index', compact('gn_divisions', 'division', 'districts', 'province'));
    }

    public function create() {}

    public function store(GNDivisionCreateRequest $request)
    {
        $gn_division = new GNDivision();
        $gn_division->code = $request->gn_code;
        $gn_division->name = $request->gn_name;
        $gn_division->divisional_secretariat_id = $request->ds_name;
        $gn_division->save();

        toast('GN Division Created Successfully', 'success')->width(400);
        return redirect()->route('admin.gn-division.index');
    }

    public function show(string $id) {}

    public function edit(string $id)
    {
        $gn_division = GNDivision::findOrFail($id);
        return view('admin.gn-division.edit', compact('gn_division'));
    }

    public function update(Request $request, string $id)
    {
        $gn_division = GNDivision::findOrFail($id);
        $gn_division->code = $request->gn_code_update;
        $gn_division->name = $request->gn_name_update;
        $gn_division->divisional_secretariat_id = $request->ds_name_update;
        $gn_division->save();

        toast('GN Division Updated Successfully', 'success')->width(400);
        return redirect()->route('admin.gn-division.index');
    }

    public function destroy(string $id)
    {
        try {
            $gn_division = GNDivision::findOrFail($id);
            $gn_division->delete();
            
            return response(['status' => 'success', 'message' => 'GN Division Delete Successfully']);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    public function filter(Request $request)
    {
        $districts_filter = GNDivision::with('divisionalSecretariat')->where(['divisional_secretariat_id' => $request->ds_id, 'delete_status' => 1])->get();
        return response()->json($districts_filter);
    }
}
