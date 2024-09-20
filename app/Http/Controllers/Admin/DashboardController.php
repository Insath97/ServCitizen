<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Request as ModelsRequest;
use App\Models\Status;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $startOfDay = Carbon::today();
        $endOfDay = Carbon::tomorrow();

        $today_request = ModelsRequest::whereBetween('created_at', [$startOfDay, $endOfDay])->count();
        $total_clients = Client::count();
        $today_amount_total = Payment::where('created_at', Carbon::today())->sum('amount');
        $todal_amount = Payment::all()->sum('amount');
        $free_tokens = ModelsRequest::where('payment_status', 'free')->count();
        $paid_tokens = ModelsRequest::where('payment_status', 'paid')->count();
        $non_free_tokens = ModelsRequest::where('payment_status', '!=', 'free')->count();


        $statuses = Status::withCount('requests')->get();

        $chartData = [
            'labels' => $statuses->pluck('status_name'),
            'counts' => $statuses->pluck('requests_count'),
            'colors' => $statuses->pluck('status_color')
        ];

        return view('admin.dashboard.index', compact('free_tokens', 'non_free_tokens', 'today_request', 'total_clients', 'todal_amount', 'paid_tokens', 'chartData'));
    }
}
