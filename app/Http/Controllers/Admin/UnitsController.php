<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnitCreateRequest;
use App\Http\Requests\UnitUpdateRequest;
use App\Models\Branch;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Unit Index,admin'])->only(['index']);
        $this->middleware(['permission:Unit Create,admin'])->only(['store']);
        $this->middleware(['permission:Unit Update,admin'])->only(['update']);
        $this->middleware(['permission:Unit Delete,admin'])->only('destroy');
    }

    public function index()
    {
        $branches  = Branch::where('status', 1)->get();
        $units = Unit::where('status', 1)->get();
        return view('admin.unit.index', compact('branches', 'units'));
    }

    public function create() {}

    public function store(UnitCreateRequest $request)
    {
        $unit = new Unit();

        $unit->unit_name = $request->unit_name;
        $unit->branch_id = $request->branch_id;
        $unit->save();

        toast('New Sub Unit Added Successfully', 'success')->width(400);
        return redirect()->route('admin.units.index');
    }

    public function show(string $id) {}

    public function edit(string $id) {}

    public function update(UnitUpdateRequest $request, string $id)
    {
        $unit = Unit::findOrFail($id);

        $unit->unit_name = $request->unit_name_update;
        $unit->branch_id = $request->branch_id_update;
        $unit->save();

        toast('Sub Unit Updated Successfully', 'success')->width(400);
        return redirect()->route('admin.units.index');
    }

    public function destroy(string $id)
    {
        try {

            $unit = Unit::findOrFail($id);
            $unit->delete();
            

            return response(['status' => 'success', 'message' => 'Sub unit Delete Successfully']);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}
