<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:System Setting Index,admin'])->only(['index','generalUpdate','appearanceUpdate']);
    }

    public function index()
    {
        return view('admin.system-setting.index');
    }

    public function generalUpdate(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_office_name' => 'required|string|max:255',
            'site_office_mail' => 'required|email|max:255',
            'site_company_name' => 'required|string|max:255',
        ]);


        Setting::updateOrCreate(
            ['key' => 'site_name'],
            ['value' => $request->site_name]
        );

        Setting::updateOrCreate(
            ['key' => 'site_office_name'],
            ['value' => $request->site_office_name]
        );

        Setting::updateOrCreate(
            ['key' => 'site_office_mail'],
            ['value' => $request->site_office_mail]
        );

        Setting::updateOrCreate(
            ['key' => 'site_company_name'],
            ['value' => $request->site_company_name]
        );

        toast('General Setting Updated Successfully', 'success')->width(400);
        return redirect()->back();
    }

    public function appearanceUpdate(Request $request)
    {
        Setting::updateOrCreate(
            ['key' => 'site_color'],
            ['value' => $request->site_color]
        );

        toast('Appearance Setting Updated Successfully', 'success')->width(400);
        return redirect()->back();
    }
}
