<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Config\PolicyController;
use App\Http\Controllers\Config\SystemPolicyController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['authenticationMiddlewares'])->group(function () {
    Route::get('/', function () {
        // return redirect()->route('homepage');
        return redirect()->route('loginPage');
    });

    Route::get('login', [AuthController::class, 'login'])->name('loginPage');
    Route::post('login/submit', [AuthController::class, 'authLogin'])->name('submitLoginRequest');
    Route::get('register', [AuthController::class, 'register'])->name('registrationPage');
    Route::post('register/submit', [AuthController::class, 'submitUserRegistrationRequest'])->name('submitUserRegistrationRequest');


    Route::get('logout', [AuthController::class, 'AuthLogout'])->name('logoutRequest');
    Route::get('forgot_password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
    Route::post('forgot_password/send_password_reset_link', [AuthController::class, 'requestPasswordResetLink'])->name('requestPasswordResetLink');
    Route::get('reset_password/{token}', [AuthController::class, 'passwordResetPage'])->name('passwordResetLink');
    Route::post('reset_password/change_password/{token}', [AuthController::class, 'submitPasswordResetRequest'])->name('submitPasswordResetRequest');

    Route::get('maintenance_mode', [AuthController::class, 'maintenanceMode'])->name('maintenanceMode');

    Route::get('verify_email', [AuthController::class, 'verifyUserEmail'])->name('verifyUserEmail');
    Route::get('verify_email/resend_otp', [AuthController::class, 'resendEmailVerificationCodeEmailtoUser'])->name('verifyUserEmailResendOtp');
    Route::post('verify_email/submit', [AuthController::class, 'verifyUserEmailSubmit'])->name('verifyUserEmailSubmit');


    Route::get('login/authenticate', [AuthController::class, 'authenticateLogin'])->name('authenticateLogin');
    Route::post('login/authenticate/submit', [AuthController::class, 'verifyLoginOtpSubmit'])->name('verifyLoginOtpSubmit');
    Route::get('login/authenticate/resend_otp', [AuthController::class, 'resendLoginOtp'])->name('resendLoginOtp');

    // Policy Agreement
    Route::get('system/configuration/policies_and_terms/user/manage', [SystemPolicyController::class, 'manageSystemPolicyAgreement'])->name('manageSystemPolicyAgreement');
    Route::post('system/configuration/policies_and_terms/user/agree', [SystemPolicyController::class, 'userAgreeToSystemPolicy'])->name('userAgreeToSystemPolicy');

    // // session management
    Route::get('manage_sessions', [AuthController::class, 'manageSession'])->name('manageSession');
    Route::get('end_other_sessions', [AuthController::class, 'endOtherSessions'])->name('endOtherSessions');
    Route::get('inactive_account', [AuthController::class, 'inactiveAccount'])->name('inactiveAccount');
});

// members routes
Route::middleware(['authenticationMiddlewares', 'memberMiddlewares'])->group(function () {
    Route::get('member/dashboard', [DashboardController::class, 'dashboard'])->name('memberDashboard');
});

// admin routes
Route::middleware(['authenticationMiddlewares', 'adminMiddlewares'])->group(function () {
    Route::get('admin/dashboard', [DashboardController::class, 'dashboard'])->name('adminDashboard');

    // policies
    Route::get('admin/config/policies', [SystemPolicyController::class, 'policies'])->name('policies');
    Route::get('admin/config/policies/search', [SystemPolicyController::class, 'policies'])->name('policiesSearch');
    Route::get('admin/config/policy/create', [SystemPolicyController::class, 'newPolicy'])->name('newPolicy');
    Route::post('admin/config/policy/create/submit', [SystemPolicyController::class, 'addNewSystemPolicySubmit'])->name('addNewSystemPolicySubmit');
});
