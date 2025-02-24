<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServicesCreateRequest;
use App\Http\Requests\ServicesUpdateRequest;
use App\Models\Branch;
use App\Models\MainServiceType;
use App\Models\Service;
use App\Models\ServiceType;
use App\Models\SubService;
use App\Models\Unit;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Service Index,admin'])->only(['index', 'fetchUnit']);
        $this->middleware(['permission:Service Create,admin'])->only(['create', 'store', 'fetchUnit']);
        $this->middleware(['permission:Service Update,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:Service Delete,admin'])->only('destroy');
    }

    public function index()
    {
        $services = Service::where(['have_sub_service' => 1, 'delete_status' => 1])->get();

        return view('admin.services.index', compact('services'));
    }

    public function fetchUnit(Request $request)
    {
        $unit = Unit::where(['branch_id' => $request->branch_id, 'status' => 1])->get();
        return $unit;
    }

    public function fetchType(Request $request)
    {
        $main_service_type = MainServiceType::where(['id' => $request->service_id])->get();

        if ($main_service_type->have_sub_service == 1) {
        }
        return $main_service_type;
    }

    public function create()
    {
        $branches = Branch::where('status', 1)->get();
        $service_type = ServiceType::where('delete_status', 1)->get();
        return view('admin.services.create', compact('branches', 'service_type'));
    }

    public function store(ServicesCreateRequest $request)
    {
        if ($request->has_subservices == 1) {

            $main_service = new MainServiceType();
            $main_service->service_type_id = $request->service_type;
            $main_service->code = $request->service_code;
            $main_service->name = $request->name;
            $main_service->save();

            $service = new Service();
            $service->service_type_id = $request->service_type;
            $service->code = $request->service_code;
            $service->name = $request->name;
            $service->main_service_type_id = $main_service->id;
            $service->branch_id = $request->branch_id;
            $service->unit_id = $request->unit_id;
            $service->fees_type = $request->fees_type;
            $service->amount = $request->amount;
            $service->r_time_type = $request->r_time_type;
            $service->r_time = $request->r_time;
            $service->save();

            toast('Service created successfully', 'success')->width(400);
            return redirect()->route('admin.services.index');
        } else {
            $main_service = new MainServiceType();
            $main_service->service_type_id = $request->service_type;
            $main_service->code = $request->service_code;
            $main_service->name = $request->name;
            $main_service->have_sub_service = 0;
            $main_service->save();

            toast('Main Service created successfully', 'success')->width(400);
            return redirect()->route('admin.services.index');
        }
    }

    public function show(string $id) {}

    public function edit(string $id)
    {
        $service = Service::findOrFail($id);
        $service_type = ServiceType::where('delete_status', 1)->get();
        $branches = Branch::where('status', 1)->get();
        $unit = Unit::where(['branch_id' => $service->branch_id, 'status' => 1])->get();
        return view('admin.services.edit', compact('service', 'branches', 'unit', 'service_type'));
    }

    public function update(ServicesUpdateRequest $request, string $id)
    {
        if ($request->has_subservices == 1) {
            $service = Service::findOrFail($id);
            $service->service_type_id = $request->service_type;
            $service->code = $request->service_code;
            $service->name = $request->name;
            $service->branch_id = $request->branch_id;
            $service->unit_id = $request->unit_id;
            $service->fees_type = $request->fees_type;
            $service->amount = $request->amount;
            $service->r_time_type = $request->r_time_type;
            $service->r_time = $request->r_time;
            $service->save();

            $main_service = MainServiceType::findOrFail($service->main_service_type_id);
            $main_service->service_type_id = $request->service_type;
            $main_service->code = $request->service_code;
            $main_service->name = $request->name;
            $main_service->save();

            toast('Service Updated successfully', 'success')->width(400);
            return redirect()->route('admin.services.index');
        } else {
            $service = Service::findOrFail($id);
            $service->have_sub_service = 0;
            $service->save();

            toast('Service Updated successfully', 'success')->width(400);
            return redirect()->route('admin.services.index');
        }
    }


    public function destroy(string $id)
    {
        try {
            $service = Service::findOrFail($id);

            $main_service = MainServiceType::find($service->main_service_type_id);
            if ($main_service) {
                $main_service->delete();
            }

            // Delete the service
            $service->delete();

            return response(['status' => 'success', 'message' => 'Service Delete Successfully']);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    public function checkServiceCode(Request $request)
    {
        $service = Service::where('code', $request->service_code)->first();
        if ($service) {
            return response()->json([
                'exists' => true,
                'service_name' => $service->name
            ]);
        } else {
            return response()->json([
                'exists' => false
            ]);
        }
    }

    private function createSubService($request, $service_code)
    {
        $sub_service = new SubService();
        $sub_service->code = $request->subservice_code;
        $sub_service->name = $request->subservice_name;
        $sub_service->service_code = $service_code;
        $sub_service->service_type_id = $request->service_type;
        $sub_service->branch_id = $request->branch_id;
        $sub_service->unit_id = $request->unit_id;
        $sub_service->fees_type = $request->fees_type;
        $sub_service->amount = $request->amount;
        $sub_service->r_time = $request->r_time;
        $sub_service->r_time_type = $request->r_time_type;

        $sub_service->save();
    }

    private function updateSubService($request, SubService $sub_service)
    {
        $sub_service->code = $request->subservice_code;
        $sub_service->name = $request->subservice_name;
        $sub_service->service_type_id = $request->service_type;
        $sub_service->branch_id = $request->branch_id;
        $sub_service->unit_id = $request->unit_id;
        $sub_service->fees_type = $request->fees_type;
        $sub_service->amount = $request->amount;
        $sub_service->r_time = $request->r_time;
        $sub_service->r_time_type = $request->r_time_type;

        $sub_service->save();
    }
}
