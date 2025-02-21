<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchRequest;
use App\Http\Requests\BranchUpdateRequest;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Branch Index,admin'])->only('index');
        $this->middleware(['permission:Branch Create,admin'])->only('create', 'store');
        $this->middleware(['permission:Branch Update,admin'])->only('edit', 'update');
        $this->middleware(['permission:Branch Delete,admin'])->only('destroy');
    }

    public function index()
    {
        $branches = Branch::where('status', 1)->get();
        return view('admin.branch.index', compact('branches'));
    }

    public function create() {}

    public function store(BranchRequest $request)
    {
        $branch = new Branch();

        $branch->name = $request->branch;
        $branch->floor = $request->floor_name;
        $branch->save();

        toast('New Branch Added Successfully', 'success')->width(400);
        return redirect()->route('admin.branch.index');
    }

    public function show(string $id) {}

    public function edit(string $id) {}

    public function update(BranchUpdateRequest $request, string $id)
    {
        $branch = Branch::findOrFail($id);

        $branch->name = $request->branch_update;
        $branch->floor = $request->floor_name_update;
        $branch->save();

        toast('Branch Updated Successfully', 'success')->width(400);
        return redirect()->route('admin.branch.index');
    }

    public function destroy(string $id)
    {
        try {

            $branch = Branch::findOrFail($id);
            $branch->delete();
            
            return response(['status' => 'success', 'message' => 'Branch Delete Successfully']);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}
