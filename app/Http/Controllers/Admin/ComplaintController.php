<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComplaintRequest;
use App\Http\Requests\UpdateComplaintRequest;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:Request Index,admin'])->only(['index', 'printToken']);
        $this->middleware(['permission:Request Create,admin'])->only(['create', 'store', 'printToken']);
        $this->middleware(['permission:Request Update,admin'])->only(['update']);
        $this->middleware(['permission:Request Delete,admin'])->only('destroy');
    }

    public function index()
    {
        $complaints = Complaint::where('delete_status', 1)->get();
        return view('admin.complaint.index', compact('complaints'));
    }

    public function create()
    {
        return view('admin.complaint.create');
    }

    public function store(StoreComplaintRequest $request)
    {
        $complaint = new Complaint();

        // Generate the complaint code
        $latestComplaint = Complaint::latest('id')->first();

        if ($latestComplaint) {
            $latestPrefix = substr($latestComplaint->code, 0, 2); // Assuming code has a prefix of 2 characters
            $latestNumber = substr($latestComplaint->code, 2); // Get the numeric part

            if ($latestNumber == '99999999') {
                $newPrefix = str_pad($latestPrefix + 1, 2, '0', STR_PAD_LEFT); // Increment prefix
                $newNumber = '00000001'; // Reset to '00000001'
            } else {
                $newPrefix = $latestPrefix;
                $newNumber = str_pad($latestNumber + 1, 8, '0', STR_PAD_LEFT); // Increment number
            }
        } else {
            $newPrefix = '01'; // Default prefix
            $newNumber = '00000001'; // Default number
        }

        // Combine the new prefix and new number to form the full complaint code
        $newCode = $newPrefix . $newNumber;

        // Check if the generated code already exists
        while (Complaint::where('code', $newCode)->exists()) {
            $newNumber = str_pad((intval($newNumber) + 1), 8, '0', STR_PAD_LEFT); // Increment the number
            $newCode = $newPrefix . $newNumber; // Update the code with the new number
        }

        // Assign the generated values to the complaint object
        $complaint->code = $newCode;
        $complaint->complaint_type = $request->complaint_type;
        $complaint->complainant_name = $request->complainant_name ?? 'Anonymous';
        $complaint->complainant_email = $request->complainant_email ?? 'Anonymous';
        $complaint->platform = $request->platform ?? 'N/A';
        $complaint->complainant_name_offline = $request->complainant_name_offline ?? 'Anonymous';
        $complaint->complainant_nic_offline = $request->complainant_nic_offline ?? 'Anonymous';
        $complaint->subject = $request->subject;
        $complaint->description = $request->description;

        $complaint->save();

        return response()->json([
            'status' => 'success', // Add this line to ensure the status is sent back
            'success' => 'Complaint created successfully.',
            'redirect' => route('admin.complaint.index') // Ensure this is correctly formatted
        ]);
    }


    public function show(string $id) {}

    public function edit(string $id)
    {
        $complaint = Complaint::findOrFail($id);
        return view('admin.complaint.edit', compact('complaint'));
    }

    public function update(UpdateComplaintRequest $request, string $id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->complaint_type = $request->complaint_type;
        $complaint->complainant_name = $request->complainant_name ?? 'Anonymous';
        $complaint->complainant_email = $request->complainant_email ?? 'Anonymous';
        $complaint->platform = $request->platform ?? 'N/A';
        $complaint->complainant_name_offline = $request->complainant_name_offline ?? 'Anonymous';
        $complaint->complainant_nic_offline = $request->complainant_nic_offline ?? 'Anonymous';
        $complaint->subject = $request->subject;
        $complaint->description = $request->description;

        $complaint->save();

        toast('Complaint Updated Successfully', 'success')->width(400);
        return redirect()->route('admin.complaint.index');
    }

    public function destroy(string $id)
    {
        try {

            $complaint = Complaint::findOrFail($id);
            $complaint->delete_status = 0;
            $complaint->save();

            return response(['status' => 'success', 'message' => 'Complaint Delete Successfully']);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}
