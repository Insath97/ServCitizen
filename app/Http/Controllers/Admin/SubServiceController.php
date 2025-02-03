<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServicesUpdateRequest;
use App\Http\Requests\SubServiceCreateRequest;
use App\Http\Requests\SubServiceUpdateRequest;
use App\Models\Branch;
use App\Models\MainServiceType;
use App\Models\Service;
use App\Models\ServiceType;
use App\Models\SubService;
use App\Models\Unit;
use Illuminate\Http\Request;

class SubServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Service Index,admin'])->only(['index', 'fetchServiceCodes']);
        $this->middleware(['permission:Service Create,admin'])->only(['create', 'store', 'fetchServiceCodes']);
        $this->middleware(['permission:Service Update,admin'])->only(['edit', 'update','fetchServiceCodes']);
        $this->middleware(['permission:Service Delete,admin'])->only('destroy');
    }


    public function index()
    {
        $services = Service::where(['have_sub_service' => 0, 'delete_status' => 1])->get();
        $service_sub = MainServiceType::all();
        $sub_services = SubService::where(['delete_status' => 1])->get();
        return view('admin.sub-service.index', compact('service_sub', 'services', 'sub_services'));
    }

    public function create()
    {
        $branches = Branch::where('status', 1)->get();
        $service_type = ServiceType::where('delete_status', 1)->get();
        $main_service = MainServiceType::with('service_type')->where(['have_sub_service' => 0])->get();
        return view('admin.sub-service.create', compact('branches', 'service_type', 'main_service'));
    }

    public function store(SubServiceCreateRequest $request)
    {
        $sub_service = new SubService();
        $sub_service->service_type_id = $request->service_type;
        $sub_service->main_service_type_id = $request->service_code;
        $sub_service->code = $request->subservice_code;
        $sub_service->name = $request->subservice_name;
        $sub_service->branch_id = $request->branch_id;
        $sub_service->unit_id = $request->unit_id;
        $sub_service->fees_type = $request->fees_type;
        $sub_service->amount = $request->amount;
        $sub_service->r_time_type = $request->r_time_type;
        $sub_service->r_time = $request->r_time;
        $sub_service->save();

        toast('Sub Service created successfully', 'success')->width(400);
        return redirect()->route('admin.sub-service.index');
    }

    public function show(string $id) {}

    public function edit(string $id)
    {
        $sub_service = SubService::findOrFail($id);
        $branches = Branch::where('status', 1)->get();
        $units = Unit::where(['branch_id' => $sub_service->branch_id, 'status' => 1])->get();
        $service_type = ServiceType::where('delete_status', 1)->get();
        $main_service = MainServiceType::with('service_type')->where(['have_sub_service' => 0])->get();
        return view('admin.sub-service.edit', compact('sub_service', 'branches', 'service_type', 'main_service', 'units'));
    }

    public function update(SubServiceUpdateRequest $request, string $id)
    {
        $sub_service = SubService::findOrFail($id);
        $sub_service->service_type_id = $request->service_type;
        $sub_service->main_service_type_id = $request->service_code;
        $sub_service->code = $request->subservice_code;
        $sub_service->name = $request->subservice_name;
        $sub_service->branch_id = $request->branch_id;
        $sub_service->unit_id = $request->unit_id;
        $sub_service->fees_type = $request->fees_type;
        $sub_service->amount = $request->amount;
        $sub_service->r_time_type = $request->r_time_type;
        $sub_service->r_time = $request->r_time;
        $sub_service->save();

        toast('Sub Service Updated successfully', 'success')->width(400);
        return redirect()->route('admin.sub-service.index');
    }

    public function destroy(string $id)
    {
        try {
            $sub_service = SubService::findOrFail($id);
            $sub_service->delete_status = 0;
            $sub_service->save();

            return response(['status' => 'success', 'message' => 'Sub Service Delete Successfully']);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    public function fetchServiceCodes(Request $request)
    {
        $serviceTypeId = $request->input('service_type_id');
        $codes = MainServiceType::where('service_type_id', $serviceTypeId)->where('have_sub_service',0)->get();
        return response()->json($codes);
    }
}
