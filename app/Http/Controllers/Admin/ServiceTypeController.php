<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceTypeCreateRequest;
use App\Models\ServiceType;
use Illuminate\Http\Request;

class ServiceTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Service Type Index,admin'])->only(['index']);
        $this->middleware(['permission:Service Type Create,admin'])->only(['store']);
        $this->middleware(['permission:Service Type Update,admin'])->only(['update']);
        $this->middleware(['permission:Service Type Delete,admin'])->only('destroy');
    }

    public function index()
    {
        $service_types = ServiceType::where('delete_status', 1)->get();
        return view('admin.service-type.index', compact('service_types'));
    }

    public function create() {}

    public function store(ServiceTypeCreateRequest $request)
    {
        $service_type = new ServiceType();

        $service_type->code = $request->service_type_code;
        $service_type->name = $request->service_type;
        $service_type->save();

        toast('new Service Type Added Successfully', 'success')->width(400);
        return redirect()->back();
    }

    public function show(string $id) {}

    public function edit(string $id) {}

    public function update(Request $request, string $id)
    {
        $service_type = ServiceType::findOrFail($id);

        $service_type->code = $request->service_type_code_update;
        $service_type->name = $request->service_type_update;
        $service_type->save();

        toast('Service Type Updated Successfully', 'success')->width(400);
        return redirect()->back();
    }

    public function destroy(string $id)
    {
        try {
            $service_type = ServiceType::findOrFail($id);
            $service_type->delete_status = 0;
            $service_type->save();

            return response(['status' => 'success', 'message' => 'Service Type Delete Successfully']);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}
