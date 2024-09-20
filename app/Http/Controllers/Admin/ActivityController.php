<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PhaseHistroy;
use App\Models\Service;
use App\Models\ServiceType;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Models\Request as ModelsRequest;
use App\Models\StatusHistory;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Token Status Index,admin'])->only(['index', 'searchToken', 'updateStatus', 'updateDocumentVerificationStatus', 'updateCallingReport', 'updateFinalDecision', 'updateFinalDecision', 'updateCompleted']);
    }

    public function index()
    {
        $service_types = ServiceType::where('delete_status', 1)->get();
        $statuses  = Status::where('delete_status', 1)->get();
        $services = Service::with('branch', 'unit')->where('delete_status', 1)->get();
        $request_services = ModelsRequest::with(['client', 'service', 'status', 'sub_service'])->where('delete_status', 1)->orderBy('created_at', 'desc')->orderBy('id', 'desc')->get();
        return view('admin.Activity.index', compact('request_services', 'service_types', 'statuses', 'services'));
    }

    public function searchToken(Request $request)
    {
        // Validate the search input
        $request->validate([
            'search' => 'required|string',
        ]);

        // Find the token with related client, service, service type, and status
        $token = ModelsRequest::with(['client', 'service', 'service', 'status', 'main_service', 'main_service.service_type', 'sub_service'])
            ->where('token_number', $request->search)
            ->first();

        // Check if the token exists
        if ($token) {
            return response()->json([
                'status' => 'success',
                'token' => $token
            ]);
        } else {
            return response()->json([
                'status' => 'no_data',
                'message' => 'No data found'
            ]);
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $update_request_status = ModelsRequest::findOrFail($request->token_id);
            $update_request_status->status_id = $request->ticket_status;
            $update_request_status->current_phase = 'open';
            $update_request_status->save();

            /* status history */
            $history = new StatusHistory();
            $history->request_id = $request->token_id;
            $history->status_id = $request->ticket_status;
            $history->feedback = $request->status_feedback;
            $history->save();

            /* phase history */
            $phase_history = new PhaseHistroy();
            $phase_history->request_id = $update_request_status->id;
            $phase_history->phase_name = $update_request_status->current_phase;
            $phase_history->status = 'open';
            $phase_history->save();

            return response()->json([
                'success' => true,
                'message' => 'Document verification status updated successfully.',
                'data' => $update_request_status
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    public function updateDocumentVerificationStatus(Request $request)
    {
        try {
            $update_request_status = ModelsRequest::findOrFail($request->token_id);
            $update_request_status->current_phase = 'document_verification';
            $update_request_status->document_verification_status = $request->documentVerificationStatus;
            $update_request_status->document_verification_date = now();
            $update_request_status->save();

            /* phase history */
            $phase_history = new PhaseHistroy();
            $phase_history->request_id = $update_request_status->id;
            $phase_history->phase_name = 'document_verification';
            $phase_history->status =  $request->documentVerificationStatus;
            $phase_history->save();


            return response()->json([
                'success' => true,
                'message' => 'Document verification status updated successfully.',
                'data' => $update_request_status
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update document verification status. Please try again later.'
            ], 500);
        }
    }

    public function updateCallingReport(Request $request)
    {
        try {
            $update_request_status = ModelsRequest::findOrFail($request->token_id);
            $update_request_status->current_phase = 'calling_report';
            $update_request_status->calling_report_status = $request->callingReportsStatus;
            $update_request_status->calling_report_date = now();
            $update_request_status->save();

            /* phase history */
            $phase_history = new PhaseHistroy();
            $phase_history->request_id = $update_request_status->id;
            $phase_history->phase_name = 'calling_report';
            $phase_history->status =  $request->callingReportsStatus;
            $phase_history->save();


            return response()->json([
                'success' => true,
                'message' => 'Calling Report status updated successfully.',
                'data' => $update_request_status
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update Calling Report status. Please try again later.'
            ], 500);
        }
    }

    public function updateFinalDecision(Request $request)
    {
        try {

            $update_request_status = ModelsRequest::findOrFail($request->token_id);
            $update_request_status->current_phase = 'final_decision';
            $update_request_status->final_decision_status = $request->finalDecisionStatus;
            $update_request_status->final_decision_date = now();

            $status = Status::where('status_name', strtolower($request->finalDecisionStatus))->first();

            if ($status) {
                $update_request_status->status_id = $status->id;
            } else {
                $update_request_status->status_id = null;
            }

            $update_request_status->save();

            /* phase history */
            $phase_history = new PhaseHistroy();
            $phase_history->request_id = $update_request_status->id;
            $phase_history->phase_name = 'final_decision';
            $phase_history->status =  $request->finalDecisionStatus;
            $phase_history->save();

            $statusDetails = $status ? [
                'status_name' => $status->status_name,
                'status_color' => $status->status_color,
            ] : [
                'status_name' => 'Unknown',
                'status_color' => '#FFFFFF',
            ];

            return response()->json([
                'success' => true,
                'message' => 'Final Decision status updated successfully.',
                'data' => [
                    'status' => $statusDetails,
                    'current_phase' => $update_request_status->current_phase,
                ]
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update Final Decision status. Please try again later.'
            ], 500);
        }
    }


    public function updateCompleted(Request $request)
    {
        try {

            $update_request_status = ModelsRequest::findOrFail($request->completed_token);

            $update_request_status->current_phase = 'completed';
            $update_request_status->completion_status = 'completed';
            $update_request_status->completion_date = now();

            $status = Status::whereRaw('LOWER(status_name) = ?', [strtolower('Completed')])->first();

            if ($status) {
                $update_request_status->status_id = $status->id;
            }

            $update_request_status->save();

            /* phase history */
            $phase_history = new PhaseHistroy();
            $phase_history->request_id = $update_request_status->id;
            $phase_history->phase_name = 'completed';
            $phase_history->status = 'completed';
            $phase_history->save();

            $statusDetails = $status ? [
                'status_name' => $status->status_name,
                'status_color' => $status->status_color,
            ] : null;

            return response()->json([
                'success' => true,
                'message' => 'Completed status updated successfully.',
                'data' => [
                    'request' => $update_request_status,
                    'status' => $statusDetails,
                    'current_phase' => 'completed'
                ]
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update completed status. Please try again later.'
            ], 500);
        }
    }


    public function create() {}

    public function store(Request $request) {}

    public function show(string $id) {}

    public function edit(string $id) {}

    public function update(Request $request, string $id) {}

    public function destroy(string $id) {}
}
