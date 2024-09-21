<?php

/* make side bar active */

use App\Models\Payment;
use App\Models\SettingInfo;
use App\Models\SubService;
use Carbon\Carbon;

function setSidebarActive(array $routes): ?string
{
    foreach ($routes as $route) {
        if (request()->routeIs($route)) {
            return 'active';
        }
    }

    return '';
}

/* check role permission */
function hasPermission(array $permission)
{
    return auth()->guard('admin')->user()->hasAnyPermission($permission);
}

/* check super admin */
function isSuperAdmin()
{
    return auth()->guard('admin')->user()->hasRole('Super Admin');
}

function canAccess(array $permission)
{
    $permission = auth()->guard('admin')->user()->hasAnyPermission($permission);
    $super_admin = auth()->guard('admin')->user()->hasRole('Super Admin');

    if ($permission || $super_admin) {
        return true;
    } else {
        return false;
    }
}

/* get user role name */
function getRole()
{
    $role = auth()->guard('admin')->user()->getRoleNames();
    return $role->first();
}

/* calculate today earnings */
function calTodayRev()
{
    $today_amount_total = Payment::where('created_at', Carbon::today())->sum('amount');
    return $today_amount_total;
}

function createSubService($request, $service_code)
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

function getSettingInfo($key)
{
    $setting_info = SettingInfo::where('key', $key)->first();
    return $setting_info ? $setting_info->value : null;
}
