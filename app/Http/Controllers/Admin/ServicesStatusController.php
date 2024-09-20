<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StatusCreateRequest;
use App\Http\Requests\StatusUpdateRequest;
use App\Models\Status;
use Illuminate\Http\Request;

class ServicesStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Status Index,admin'])->only(['index']);
        $this->middleware(['permission:Status Create,admin'])->only(['store']);
        $this->middleware(['permission:Status Update,admin'])->only(['update']);
        $this->middleware(['permission:Status Delete,admin'])->only('destroy');
    }

    public function index()
    {
        $statues = Status::where('delete_status', 1)->get();
        return view('admin.services-status.index', compact('statues'));
    }

    public function create() {}

    public function store(StatusCreateRequest $request)
    {
        $service_status = new Status();
        $service_status->status_name = $request->status_name;
        $service_status->status_color = $request->status_color;
        $service_status->save();

        toast('New Status Added Successfully', 'success')->width(400);
        return redirect()->route('admin.services-status.index');
    }

    public function show(string $id) {}

    public function edit(string $id) {}

    public function update(StatusUpdateRequest $request, string $id)
    {
        $service_status = Status::findOrFail($id);
        $service_status->status_name = $request->status_name_update;
        $service_status->status_color = $request->status_color_update;
        $service_status->save();

        toast('Status Updated Successfully', 'success')->width(400);
        return redirect()->route('admin.services-status.index');
    }

    public function destroy(string $id)
    {
        try {

            $status = Status::findOrFail($id);
            $status->delete_status = 0;
            $status->save();

            return response(['status' => 'success', 'message' => 'Status Delete Successfully']);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}
