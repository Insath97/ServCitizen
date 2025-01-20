<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use App\Models\Receipt;
use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Payment Index,admin'])->only(['index', 'store', 'searchToken']);
    }

    public function index()
    {
        $paid_token = ModelsRequest::with(['client', 'service', 'service', 'status', 'main_service', 'main_service.service_type', 'sub_service'])
            ->where('payment_status', 'Pending Payment')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.payment.index', compact('paid_token'));
    }

    public function store(PaymentRequest $request)
    {
        $status_changed = ModelsRequest::findOrFail($request->token_id);
        $status_changed->payment_status = 'Paid';
        $status_changed->save();

        $payment = new Payment();
        $payment->request_id = $request->token_id;
        $payment->payment_method = $request->payment_method;
        $payment->amount = $request->amount;
        $payment->save();

        return response()->json(['status' => 'success', 'token' => $status_changed]);
    }

    public function searchToken(Request $request)
    {
        // Validate the search input
        $request->validate([
            'search' => 'required|string',
        ]);

        // Find the token with related client, service, service type, and status
        $token = ModelsRequest::with(['client', 'service', 'service', 'status', 'main_service', 'main_service.service_type', 'sub_service'])
            ->where('id', $request->search)
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

    public function printToken(string $id)
    {
        $request_service = ModelsRequest::findOrFail($id);

        // Generate receipt number
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
        $barcodeBase64 = base64_encode($barcode);

        // Pass the token number and other data to the view for printing
        return view('admin.payment.print', compact('request_service', 'barcodeBase64'));
    }
}
