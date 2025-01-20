<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestCreateRequest;
use App\Models\Client;
use App\Models\MainServiceType;
use App\Models\Receipt;
use App\Models\Request as ModelsRequest;
use App\Models\Service;
use App\Models\ServiceType;
use App\Models\Status;
use App\Models\SubService;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorPNG;

class ServiceRequestController extends Controller
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
        $service_types = ServiceType::where('delete_status', 1)->get();
        $statuses  = Status::where(['status_name' => 'Open', 'delete_status' => 1])->get();
        $services = Service::with('branch', 'unit')->where('delete_status', 1)->get();

        $request_services = ModelsRequest::with([
            'client',
            'service',
            'status',
            'main_service',
            'main_service.service_type',
            'sub_service',
            'status_history'
        ])
            ->where('delete_status', 1)
            // ->orderByRaw("FIELD(payment_status, 'Free') DESC") // Free tokens will come first
            // ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.request.index', compact('request_services', 'service_types', 'statuses', 'services'));
    }

    public function create()
    {
        $clients = Client::with(['province', 'district', 'divisionalSecretariat', 'gndivison'])->where('delete_status', 1)->get();
        $service_types = ServiceType::where('delete_status', 1)->get();
        $services = Service::with('branch', 'unit')->where('delete_status', 1)->get();
        $statuses  = Status::where(['status_name' => 'Open', 'delete_status' => 1])->get();
        $request_services = ModelsRequest::with(['client', 'service', 'status'])->where('delete_status', 1)->orderBy('created_at', 'desc')->orderBy('id', 'desc')->get();
        return view('admin.request.create', compact('clients', 'services', 'statuses', 'service_types', 'request_services'));
    }

    public function store(RequestCreateRequest $request)
    {
        $main_service = MainServiceType::findOrFail($request->service_id);

        $request_service = new ModelsRequest();

        /* create token number with 10 digit */
        $latest_token = ModelsRequest::latest('id')->first();
        $latest_token_number = $latest_token ? $latest_token->token_number : 0;
        $new_token_number = str_pad($latest_token_number + 1, 10, '0', STR_PAD_LEFT);

        $request_service->token_number = $new_token_number;
        $request_service->client_id = $request->client_id;
        $request_service->main_service_type_id = $main_service->id;

        if ($main_service->have_sub_service == 1) {
            $service = Service::where('code', $main_service->code)->first();
            $request_service->service_id = $service->id;
            $request_service->payment_status = $service->fees_type == 'paid' ? 'Pending Payment' : 'free';
        } else {
            $sub_service = SubService::where('main_service_type_id', $main_service->id)->first();
            $request_service->sub_service_id = $sub_service->id;
            $request_service->payment_status = $sub_service->fees_type == 'paid' ? 'Pending Payment' : 'free';
        }

        $request_service->status_id = $request->status_id;
        $request_service->description = $request->notes;
        $request_service->save();

        toast('Services Request Added Successfully', 'success')->width(400);
        return redirect()->route('admin.service-request.index');
    }

    public function show(string $id) {}

    public function edit(string $id) {}

    public function update(Request $request, string $id)
    {
        $service = Service::findOrFail($request->service_id);
        $request_service = ModelsRequest::findOrFail($id);
        $request_service->client_id = $request->client_id;
        $request_service->service_id = $request->service_id;
        $request_service->status_id = $request->status_id;
        $request_service->description = $request->notes;
        $request_service->payment_status = $service->fees_type == 'paid' ? 'Pending Payment' : 'free';
        $request_service->save();

        toast('Service Request Updated Successfully', 'success')->width(400);
        return redirect()->route('admin.service-request.index');
    }

    public function destroy(string $id)
    {
        try {

            $request_service = ModelsRequest::findOrFail($id);
            $request_service->delete_status = 0;
            $request_service->save();

            return response(['status' => 'success', 'message' => 'Request Delete Successfully']);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    public function printToken(string $id)
    {
        $request_service = ModelsRequest::findOrFail($id);

        $receipt = new Receipt();

        $latest_receipt = Receipt::latest('id')->first();
        $latest_receipt_number = $latest_receipt ? $latest_receipt->receipt_number : 0;
        $new_receipt_number = str_pad($latest_receipt_number + 1, 5, '0', STR_PAD_LEFT);

        $receipt->receipt_number = $new_receipt_number;
        $receipt->request_id = $request_service->id;
        $receipt->save();

        // Generate the barcode
        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($request_service->token_number, $generator::TYPE_CODE_128);

        // Encode the barcode as a base64 string
        $barcodeBase64 = base64_encode($barcode);

        // Pass the barcode and request service data to the view
        return view('admin.request.request-print', compact('request_service', 'barcodeBase64'));
    }

    public function search(Request $request)
    {
        $client = Client::where('nic', $request->search)->orWhere('client_number', $request->search)->first();

        $search_request_client = ModelsRequest::with(['client', 'service', 'service', 'status', 'main_service', 'main_service.service_type', 'sub_service'])
            ->where([
                'client_id' => $client->id,
                'delete_status' => 1
            ])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json($search_request_client);
    }

    public function fetchMainService(Request $request)
    {
        $main_service = MainServiceType::findOrFail($request->service_id);
        return response()->json($main_service);
    }

    public function fetchSubService(Request $request)
    {
        $sub_service = SubService::where(['main_service_type_id' => $request->service_id])->get();
        return response()->json($sub_service);
    }
}
