<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Config\PolicyController;
use App\Http\Controllers\Config\SystemPolicyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Shipping\ShippingConfigController;
use App\Http\Controllers\Shop\ShopManagementController;
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

    // shop
    // product categories
    Route::get('admin/shop/product/categories', [ShopManagementController::class, 'productCategories'])->name('productCategories');
    Route::get('admin/shop/product/categories/search', [ShopManagementController::class, 'productCategories'])->name('productCategoriesSearch');
    Route::post('admin/shop/product/categories/add/submit', [ShopManagementController::class, 'addNewProductCategorySubmit'])->name('addNewProductCategorySubmit');
    Route::get('admin/shop/product/categories/view/{slug}', [ShopManagementController::class, 'viewProductCategory'])->name('viewProductCategories');
    Route::put('admin/shop/product/categories/update/{slug}', [ShopManagementController::class, 'updateProductCategory'])->name('updateProductCategory');
    Route::get('admin/shop/product/categories/delete/{slug}', [ShopManagementController::class, 'deleteProductCategory'])->name('deleteProductCategory');

    // brands
    Route::get('admin/shop/product/brands', [ShopManagementController::class, 'brands'])->name('brands');
    Route::get('admin/shop/product/brands/search', [ShopManagementController::class, 'brands'])->name('brandsSearch');
    Route::post('admin/shop/product/brands/add/submit', [ShopManagementController::class, 'addNewBrandSubmit'])->name('addNewBrandSubmit');
    Route::get('admin/shop/product/brands/view/{slug}', [ShopManagementController::class, 'viewBrands'])->name('viewBrands');
    Route::put('admin/shop/product/brands/update/{slug}', [ShopManagementController::class, 'updateBrandSubmit'])->name('updateBrandSubmit');

    // colours
    Route::get('admin/shop/product/attributes/colours', [ShopManagementController::class, 'colours'])->name('colours');
    Route::get('admin/shop/product/attributes/colours/search', [ShopManagementController::class, 'colours'])->name('coloursSearch');
    Route::post('admin/shop/product/attributes/colours/add/submit', [ShopManagementController::class, 'addNewColourSubmit'])->name('addNewColourSubmit');
    Route::put('admin/shop/product/attributes/colours/update/{id}', [ShopManagementController::class, 'updateColourSubmit'])->name('updateColourSubmit');

    // weights
    Route::get('admin/shop/product/attributes/weights', [ShopManagementController::class, 'weights'])->name('weights');
    Route::get('admin/shop/product/attributes/weights/search', [ShopManagementController::class, 'weights'])->name('weightsSearch');
    Route::post('admin/shop/product/attributes/weights/add/submit', [ShopManagementController::class, 'addNewWeightSubmit'])->name('addNewWeightSubmit');
    Route::put('admin/shop/product/attributes/weights/update/{id}', [ShopManagementController::class, 'updateWeightSubmit'])->name('updateWeightSubmit');
    Route::get('admin/shop/product/attributes/weights/delete/{id}', [ShopManagementController::class, 'deleteWeight'])->name('deleteWeight');


    // other attributes
    Route::get('admin/shop/product/attributes/others', [ShopManagementController::class, 'otherAttributes'])->name('otherAttributes');
    Route::get('admin/shop/product/attributes/others/search', [ShopManagementController::class, 'otherAttributes'])->name('otherAttributesSearch');
    Route::post('admin/shop/product/attributes/others/add/submit', [ShopManagementController::class, 'addNewAttributeSubmit'])->name('addNewAttributeSubmit');
    Route::post('admin/shop/product/attributes/others/add/submit', [ShopManagementController::class, 'addNewAttributeSubmit'])->name('addNewAttributeSubmit');
    Route::put('admin/shop/product/attributes/others/update/{id}/submit', [ShopManagementController::class, 'updateAttributeSubmit'])->name('updateAttributeSubmit');
    Route::get('admin/shop/product/attributes/others/delete/{id}/submit', [ShopManagementController::class, 'deleteAttribute'])->name('deleteAttribute');



    // shipping config
    Route::get('admin/shop/shipping/config/zones', [ShippingConfigController::class, 'shippingZones'])->name('shippingZones');
    Route::post('admin/shop/shipping/config/zones', [ShippingConfigController::class, 'createNewShippingZone'])->name('createNewShippingZone');
    Route::put('admin/shop/shipping/config/zones/{slug}/update', [ShippingConfigController::class, 'updateShippingZone'])->name('updateShippingZone');
    Route::get('admin/shop/shipping/config/zones/{slug}/delete', [ShippingConfigController::class, 'deleteShippingZone'])->name('deleteShippingZone');



    Route::get('admin/shop/shipping/config/surcharges', [ShippingConfigController::class, 'surcharges'])->name('surcharges');
    Route::post('admin/shop/shipping/config/surcharges/create_new', [ShippingConfigController::class, 'createShippingSurcharge'])->name('createShippingSurcharge');
    Route::put('admin/shop/shipping/config/surcharges/{slug}/update', [ShippingConfigController::class, 'updateShippingSurcharge'])->name('updateShippingSurcharge');
    Route::get('admin/shop/shipping/config/surcharges/{slug}/delete', [ShippingConfigController::class, 'deleteShippingSurcharge'])->name('deleteShippingSurcharge');







    Route::get('admin/shop/shipping/config/locations', [ShippingConfigController::class, 'locations'])->name('locations');
    Route::get('admin/shop/shipping/config/locations/search', [ShippingConfigController::class, 'locations'])->name('locationsSearch');
    Route::post('admin/shop/shipping/config/locations/create/submit', [ShippingConfigController::class, 'createLocationSubmit'])->name('createLocationSubmit');
    Route::put('admin/shop/shipping/config/locations/{location}/update', [ShippingConfigController::class, 'updateLocation'])->name('updateLocation');
    Route::get('admin/shop/shipping/config/locations/{location}/delete', [ShippingConfigController::class, 'deleteLocation'])->name('deleteLocation');

    Route::get('admin/shop/shipping/config/rates', [ShippingConfigController::class, 'shippingRates'])->name('shippingRates');
    Route::get('admin/shop/shipping/config/rates/search', [ShippingConfigController::class, 'shippingRates'])->name('shippingRatesSearch');









    // policies
    Route::get('admin/config/policies', [SystemPolicyController::class, 'policies'])->name('policies');
    Route::get('admin/config/policies/search', [SystemPolicyController::class, 'policies'])->name('policiesSearch');
    Route::get('admin/config/policy/create', [SystemPolicyController::class, 'newPolicy'])->name('newPolicy');
    Route::post('admin/config/policy/create/submit', [SystemPolicyController::class, 'addNewSystemPolicySubmit'])->name('addNewSystemPolicySubmit');
    Route::get('admin/config/policy/view/{slug}', [SystemPolicyController::class, 'viewPolicy'])->name('viewPolicy');
    Route::get('admin/config/policy/edit/{slug}', [SystemPolicyController::class, 'editPolicy'])->name('editPolicy');
    Route::put('admin/config/policy/update/{slug}', [SystemPolicyController::class, 'updateSystemPolicy'])->name('updateSystemPolicy');
    Route::get('admin/config/policy/delete/{slug}', [SystemPolicyController::class, 'deletePolicy'])->name('deletePolicy');
});
