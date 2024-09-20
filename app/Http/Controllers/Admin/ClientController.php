<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientCreateRequest;
use App\Http\Requests\ClientSearchRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Models\Client;
use App\Models\District;
use App\Models\Division;
use App\Models\GNDivision;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Models\Request as ModelsRequest;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Client Index,admin'])->only(['index', 'searchClient', 'print']);
        $this->middleware(['permission:Client Create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:Client Update,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:Client Delete,admin'])->only('destroy');
    }

    public function index()
    {
        $clients = Client::with(['province', 'district', 'divisionalSecretariat', 'gndivison'])->where('delete_status', 1)->get();
        return view('admin.clients.index', compact('clients'));
    }

    public function getDistricts(Request $request)
    {
        $districts = District::where(['province_id' => $request->province_id, 'delete_status' => 1])->orderBy('district', 'asc')->get();
        return $districts;
    }

    public function getDivisionalSecretariat(Request $request)
    {
        $ds = Division::where(['district_id' => $request->district_id, 'delete_status' => 1])->orderBy('name', 'asc')->get();
        return $ds;
    }

    public function getGNDivision(Request $request)
    {
        $gn_division = GNDivision::where(['divisional_secretariat_id' => $request->ds_id, 'delete_status' => 1])->orderBy('name', 'asc')->get();
        return $gn_division;
    }

    public function create()
    {
        $provinces = Province::where('delete_status', 1)->orderBy('province', 'asc')->get();
        return view('admin.clients.create', compact('provinces'));
    }

    public function store(ClientCreateRequest $request)
    {
        $client = new Client();
        $client->name = $request->name;
        $client->nic = $request->nic;

        /* create client number */
        $latestClient = Client::latest('id')->first();
        $latestClientNumber = $latestClient ? $latestClient->client_number : 0;
        $newClientNumber = str_pad($latestClientNumber + 1, 8, '0', STR_PAD_LEFT);

        $client->client_number = $newClientNumber;

        $client->gender = $request->gender;
        $client->dob = $request->dob;
        $client->street_name = $request->street;
        $client->province_id = $request->province_id;
        $client->district_id = $request->district_id;
        $client->divisional_secretariat_id = $request->ds_id;
        $client->gn_division_id = $request->division_id;
        $client->email = $request->email;
        $client->mobile = $request->mobile;
        $client->tel = $request->tel;

        $client->save();

        toast('New Client Added Successfully', 'success')->width(400);
        return redirect()->route('admin.client.index');
    }

    public function show(string $id) {}

    public function edit(string $id)
    {
        $client = Client::findOrFail($id);
        $provinces = Province::where('delete_status', 1)->orderBy('province', 'asc')->get();
        $districts = District::where('province_id', $client->province_id)->get();
        $dss = Division::where('district_id', $client->district_id)->get();
        $gn_divisions = GNDivision::where('divisional_secretariat_id', $client->divisional_secretariat_id)->get();

        return view('admin.clients.edit', compact('client', 'provinces', 'districts', 'dss', 'gn_divisions'));
    }

    public function update(ClientUpdateRequest $request, string $id)
    {
        $client = Client::findOrFail($id);
        $client->name = $request->name;
        $client->nic = $request->nic;
        $client->gender = $request->gender;
        $client->dob = $request->dob;
        $client->street_name = $request->street;
        $client->province_id = $request->province_id;
        $client->district_id = $request->district_id;
        $client->divisional_secretariat_id = $request->ds_id;
        $client->gn_division_id = $request->division_id;
        $client->email = $request->email;
        $client->mobile = $request->mobile;
        $client->tel = $request->tel;
        $client->save();

        toast('Client Updated Successfully', 'success')->width(400);
        return redirect()->route('admin.client.index');
    }

    public function destroy(string $id)
    {
        try {
            $client = Client::findOrFail($id);
            $client->delete_status = 0;
            $client->save();

            return response(['status' => 'success', 'message' => 'Client Delete Successfully']);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    public function print(string $id)
    {
        $client = Client::findOrFail($id);
        return view('admin.print.client-details-print', compact('client'));
    }

    public function search(Request $request)
    {
        $clients = Client::with(['province', 'district', 'divisionalSecretariat', 'gndivison'])
            ->where('nic', 'like', '%' . $request->search . '%')
            ->orWhere('client_number', 'like', '%' . $request->search . '%')
            ->get();

        return response()->json($clients);
    }

    public function searchClient(Request $request)
    {
        $client = Client::where('nic',  $request->search)
            ->orWhere('client_number', $request->search)
            ->with(['province', 'district', 'divisionalSecretariat', 'gndivison', 'requestServices' => function ($query) {
                $query->with(['client', 'service', 'service', 'status', 'main_service', 'main_service.service_type', 'sub_service'])->orderBy('created_at', 'desc')->take(5);
            }])
            ->first();

        if ($client) {
            return response()->json([
                'status' => 'success',
                'client' => $client,
                'requests' => $client->requestServices
            ]);
        } else {
            return response()->json([
                'status' => 'no_data',
                'message' => 'No data found'
            ]);
        }
    }
}
