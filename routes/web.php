<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*****************************************************************************/

/* USER ROUTES */

Route::get('/home', 'User\UserController@index')->name('home');
Route::get('/referral_link', 'User\ReferralController@index')->name('referral');
Route::get('/myreferral', 'User\MyReferralController@index')->name('my_referral');
Route::get('/changepassword', 'User\ChangePasswordController@index')->name('changepassword_page');
Route::post('/changepassword', 'User\ChangePasswordController@changePassword')->name('change_password');
Route::get('/editprofile', 'User\EditProfileController@index')->name('editprofile_form');
Route::post('/editprofile', 'User\EditProfileController@update')->name('editprofile');

Route::get('/referral/', 'User\LandingPageController@index')->name('landing_page');
Route::get('site-register', 'SiteAuthController@siteRegister');
Route::post('site-register', 'SiteAuthController@siteRegisterPost');

Route::get('/registeration_successful', function() {
    return view('registered');
})->name('registeration_successful');


Route::group(['namespace' => 'User\Auth'], function () {

    // Authentication Routes...
     Route::get('/', 'LoginController@showLoginForm')->name('login_page');
    Route::get('login', 'LoginController@showLoginForm')->name('login_page');
    Route::post('login', 'LoginController@login')->name('login');
    Route::post('logout', 'LoginController@logout')->name('logout');

    // Registration Routes...
    Route::get('register/{ibm}', 'RegisterController@showRegistrationForm')->name('register_page');
    Route::post('register', 'RegisterController@register')->name('register');
    Route::get('register/activate/{token}', 'RegisterController@confirm')->name('email_confirm');

    // Password Reset Routes...
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');

});

//User Group Products List

Route::get('group-products-list' , 'User\GroupProductController@index')->name('user.group-products');

//User Products List
Route::get('products-list' , 'User\ProductController@index')->name('user.products');

//CareCover User Reward
Route::get('rewards' , 'User\RewardController@index')->name('user.rewards');


// User Transactions

Route::get('transactions' , 'User\TransactionController@index')->name('user.transactions');
Route::post('searchTransactions' , 'User\TransactionController@searchTransaction')->name('user.transactions.search');

// User Commissions

Route::get('commissions' , 'User\CommissionController@index')->name('user.commissions');
Route::post('searchCommissions' , 'User\CommissionController@searchCommission')->name('user.commissions.search');
Route::get('downloadCommissions' , 'User\CommissionController@downloadCommission')->name('user.commissions.download');

Route::get('downloadView' , 'User\CommissionController@downloadView');


//Group Profit Earned
Route::get('group-profit-earned' , 'User\GroupProfitEarnedController@index')->name('user.group_profit_earned');
Route::post('search-group-profit-earned' , 'User\GroupProfitEarnedController@searchProfit')->name('user.group_profit_earned.search');



/* ADMIN ROUTES */

Route::group(['namespace' => 'Admin\Auth'], function () {
    // Authentication Routes...
    Route::get('admin/login', 'LoginController@showLoginForm')->name('admin_login_page');
    Route::post('admin/login', 'LoginController@login')->name('admin_login');
    Route::post('admin/logout', 'LoginController@logout')->name('admin_logout');

    //admin password reset routes
    Route::post('admin/password/email','ForgotPasswordController@sendResetLinkEmail')->name('admin_password_email');
    Route::get('admin/password/reset','ForgotPasswordController@showLinkRequestForm')->name('admin_password_request');
    Route::post('admin/password/reset','ResetPasswordController@reset')->name('admin_password_update');
    Route::get('admin/password/reset/{token}','ResetPasswordController@showResetForm')->name('admin_password_reset');
});



//Admin Main

Route::get('admin/home', 'Admin\AdminController@index')->name('admin_home');


//BUSINESS BUILDERS MEMBERS

Route::get('admin/mymembers', 'Admin\MyMemberController@index')->name('admin_mymembers');

Route::get('admin/mycommissions' , 'Admin\BusinessBuilderCommissionController@index')->name('business_builder.commissions');
Route::post('admin/mycommissions' , 'Admin\BusinessBuilderCommissionController@searchCommission')->name('business_builder.searchCommissions');

Route::post('admin/scheme_assign', 'Admin\SchemeAssignController@store')->name('admin.scheme_assign');

Route::post('admin/bb_assign', 'Admin\BBAssignController@store')->name('admin.bb_assign');

//Admin Subscribed Members

Route::get('admin/subscribed_members/all', 'Admin\SubscribedMembersController@all')->name('admin_subscribed_members_all');
Route::get('admin/subscribed_members/assigned', 'Admin\SubscribedMembersController@assigned')->name('admin_subscribed_members_assigned');
Route::get('admin/subscribed_members/unassigned', 'Admin\SubscribedMembersController@unassigned')->name('admin_subscribed_members_unassigned');
Route::get('admin/subscribed_members/groups', 'Admin\SubscribedMembersController@groups')->name('admin_subscribed_members_groups');

//Admin Product Assigne

Route::post('admin/productassign', 'Admin\ProductAssignController@store')->name('admin_productassign');

//Admin Member Rewards

Route::get('admin/member/rewards/{ibm}/{name}', 'Admin\RewardController@index')->name('admin_members_reward');


//Admin Transactions
Route::get('admin/import_transactions', 'Admin\ImportController@index')->name('admin_import_transactions');


//Admin Password
Route::get('admin/changepassword', 'Admin\ChangePasswordController@index')->name('admin_changepassword_page');
Route::post('admin/changepassword', 'Admin\ChangePasswordController@changePassword')->name('admin_change_password');



//IMPORT TEST


Route::get('admin/transactions', 'Admin\TransactionController@index')->name('transactions.index');

Route::get('admin/transaction/confirmation', 'Admin\TempTransactionController@index')->name('admin.transactions.confirmation');

Route::post('admin/transaction/confirm', 'Admin\TempTransactionController@confirm')->name('admin.transactions.confirm');

Route::post('admin/transaction/rollback', 'Admin\TempTransactionController@rollback')->name('admin.transactions.rollback');

Route::post('admin/import_parse', [\App\Http\Controllers\ImportController::class, 'parseImport'])->name('import_parse');

Route::post('admin/import_process', [\App\Http\Controllers\ImportController::class, 'processImport'])->name('import_process');

//Reconcillation
Route::get('admin/reconcile' , [\App\Http\Controllers\Admin\ReconcillationController::class , 'index']);

Route::post('admin/reconcile' , [\App\Http\Controllers\Admin\ReconcillationController::class , 'reconcillation'])->name('reconcile');


//User Management

Route::group(['middleware' => ['auth:admin']], function() {
    Route::resource('admin/roles', Admin\RoleController::class);
    Route::resource('admin/users', Admin\UserController::class);
});

//Products CRUD

Route::group(['middleware' => ['auth:admin']] , function(){
    Route::resource('admin/products', Admin\ProductController::class);    
});

//Dummy transaction
ROute::get('admin/addTransaction' , 'Admin\TransactionController@addTrans');
ROute::post('admin/addTransaction' , 'Admin\TransactionController@store')->name('admin_add_trans');





