<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\AuthenticationController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ComplaintController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\DivisionController as AdminDivisionController;
use App\Http\Controllers\Admin\GNDivisionController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProvinceController as AdminProvinceController;
use App\Http\Controllers\Admin\RequestController;
use App\Http\Controllers\Admin\RolesPermissionController;
use App\Http\Controllers\Admin\ServiceRequestController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\ServicesStatusController;
use App\Http\Controllers\Admin\ServiceTypeController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubServiceController;
use App\Http\Controllers\Admin\UnitsController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\ProvinceController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    /* login route */
    Route::get('login', [AuthenticationController::class, 'login'])->name('login');
    Route::post('login', [AuthenticationController::class, 'handleLogin'])->name('handle-login');

    /* logout */
    Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');

    /* forgot password */
    Route::get('forgot-password', [AuthenticationController::class, 'ForgotPassword'])->name('forgot-password');
    Route::post('forgot-password', [AuthenticationController::class, 'sendRestLink'])->name('forgot-password.send');

    /* reset password */
    Route::get('reset-password/{token}', [AuthenticationController::class, 'ResetPassword'])->name('reset-password');
    Route::post('reset-password', [AuthenticationController::class, 'HandleResetPassword'])->name('reset-password.send');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['admin']], function () {

    /* profile */
    Route::put('profile-password-update/{id}', [ProfileController::class, 'passwordUpdate'])->name('profile-password-update');
    Route::resource('profile', ProfileController::class);

    /* dasboard */
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /* Provinces */
    Route::resource('province', AdminProvinceController::class);

    /* district */
    Route::get('province-filter', [DistrictController::class, 'filter'])->name('province-filter');
    Route::resource('district', DistrictController::class);

    /* Divisional Secretariats */
    Route::get('district-filter', [AdminDivisionController::class, 'filter'])->name('district-filter');
    Route::resource('division', AdminDivisionController::class);

    /* GN Divisions */
    Route::get('ds-filter', [GNDivisionController::class, 'filter'])->name('ds-filter');
    Route::resource('gn-division', GNDivisionController::class);

    /* branch */
    Route::resource('branch', BranchController::class);

    /* units */
    Route::resource('units', UnitsController::class);

    /* services status */
    Route::resource('services-status', ServicesStatusController::class);

    /* service type */
    Route::resource('service-type', ServiceTypeController::class);

    /* services */
    Route::get('check-service-code', [ServicesController::class, 'checkServiceCode'])->name('check-service-code');
    Route::get('fetch-service-type', [ServicesController::class, 'fetchType'])->name('fetch-service-type');
    Route::get('fetch-service-unit', [ServicesController::class, 'fetchUnit'])->name('fetch-service-unit');
    Route::resource('services', ServicesController::class);

    /* sub service */
    Route::get('fetch-service-codes', [SubServiceController::class, 'fetchServiceCodes'])->name('fetch-service-codes');
    Route::resource('sub-service', SubServiceController::class);

    /* request */
    Route::get('fetch-main-service', [ServiceRequestController::class, 'fetchMainService'])->name('fetch-main-service');
    Route::get('fetch-subservice', [ServiceRequestController::class, 'fetchSubService'])->name('fetch-subservice');
    Route::get('search-client-request', [ServiceRequestController::class, 'search'])->name('search-client-request');
    Route::get('token-number/{code}', [ServiceRequestController::class, 'printToken'])->name('token-number');
    Route::get('service-request/{id}/print', [ServiceRequestController::class, 'printToken'])->name('service-request.print');
    Route::resource('service-request', ServiceRequestController::class);

    /* client */
    Route::get('get-districts', [ClientController::class, 'getDistricts'])->name('get-districts');
    Route::get('get-divisional-secretariat', [ClientController::class, 'getDivisionalSecretariat'])->name('get-divisional-secretariat');
    Route::get('get-gn-divison', [ClientController::class, 'getGNDivision'])->name('get-gn-divison');
    Route::get('client-details/{id}/print', [ClientController::class, 'print'])->name('client-details.print');
    Route::get('search-client', [ClientController::class, 'searchClient'])->name('search-client');
    Route::resource('client', ClientController::class);

    /* permissions */
    Route::resource('permission', PermissionController::class);

    /* roles*/
    Route::get('role', [RolesPermissionController::class, 'index'])->name('role.index');
    Route::get('role/create', [RolesPermissionController::class, 'create'])->name('role.create');
    Route::post('role/create', [RolesPermissionController::class, 'store'])->name('role.store');
    Route::get('role/{id}/edit', [RolesPermissionController::class, 'edit'])->name('role.edit');
    Route::put('role/{id}/edit', [RolesPermissionController::class, 'update'])->name('role.update');
    Route::delete('role/{id}/destroy', [RolesPermissionController::class, 'destroy'])->name('role.destroy');

    /* user role */
    Route::resource('user-role', UserRoleController::class);

    /* payment */
    Route::get('payment-search', [PaymentController::class, 'searchToken'])->name('payment.search');
    Route::get('token/{id}/print', [PaymentController::class, 'printToken'])->name('token.print');
    Route::get('payment', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('payment/create', [PaymentController::class, 'store'])->name('payment.store');

    /* activity */
    Route::get('request-search', [ActivityController::class, 'searchToken'])->name('request-search');
    Route::post('update-status', [ActivityController::class, 'updateStatus'])->name('update-status');
    Route::post('update-status-one', [ActivityController::class, 'updateDocumentVerificationStatus'])->name('update-status-one');
    Route::post('update-status-two', [ActivityController::class, 'updateCallingReport'])->name('update-status-two');
    Route::post('update-status-three', [ActivityController::class, 'updateFinalDecision'])->name('update-status-three');
    Route::post('update-status-four', [ActivityController::class, 'updateCompleted'])->name('update-status-four');
    Route::resource('activity', ActivityController::class);

    /* system setting */
    Route::get('setting', [SettingController::class, 'index'])->name('setting.index');
    Route::put('general-setting', [SettingController::class, 'generalUpdate'])->name('general-setting.update');
    Route::put('appearance', [SettingController::class, 'appearanceUpdate'])->name('appearance.update');
    Route::put('version', [SettingController::class, 'versionUpdate'])->name('version.update');

    /* compalint */
    Route::resource('complaint', ComplaintController::class);
});
