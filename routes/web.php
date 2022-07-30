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


// Route::get('/', function () {
//     return view('dashboard');
// });

Route::group(['prefix' => 'email'], function(){
    Route::get('inbox', function () { return view('pages.email.inbox'); });
    Route::get('read', function () { return view('pages.email.read'); });
    Route::get('compose', function () { return view('pages.email.compose'); });
});

Route::group(['prefix' => 'apps'], function(){
    Route::get('chat', function () { return view('pages.apps.chat'); });
    Route::get('calendar', function () { return view('pages.apps.calendar'); });
});

Route::group(['prefix' => 'ui-components'], function(){
    Route::get('alerts', function () { return view('pages.ui-components.alerts'); });
    Route::get('badges', function () { return view('pages.ui-components.badges'); });
    Route::get('breadcrumbs', function () { return view('pages.ui-components.breadcrumbs'); });
    Route::get('buttons', function () { return view('pages.ui-components.buttons'); });
    Route::get('button-group', function () { return view('pages.ui-components.button-group'); });
    Route::get('cards', function () { return view('pages.ui-components.cards'); });
    Route::get('carousel', function () { return view('pages.ui-components.carousel'); });
    Route::get('collapse', function () { return view('pages.ui-components.collapse'); });
    Route::get('dropdowns', function () { return view('pages.ui-components.dropdowns'); });
    Route::get('list-group', function () { return view('pages.ui-components.list-group'); });
    Route::get('media-object', function () { return view('pages.ui-components.media-object'); });
    Route::get('modal', function () { return view('pages.ui-components.modal'); });
    Route::get('navs', function () { return view('pages.ui-components.navs'); });
    Route::get('navbar', function () { return view('pages.ui-components.navbar'); });
    Route::get('pagination', function () { return view('pages.ui-components.pagination'); });
    Route::get('popovers', function () { return view('pages.ui-components.popovers'); });
    Route::get('progress', function () { return view('pages.ui-components.progress'); });
    Route::get('scrollbar', function () { return view('pages.ui-components.scrollbar'); });
    Route::get('scrollspy', function () { return view('pages.ui-components.scrollspy'); });
    Route::get('spinners', function () { return view('pages.ui-components.spinners'); });
    Route::get('tabs', function () { return view('pages.ui-components.tabs'); });
    Route::get('tooltips', function () { return view('pages.ui-components.tooltips'); });
});

Route::group(['prefix' => 'advanced-ui'], function(){
    Route::get('cropper', function () { return view('pages.advanced-ui.cropper'); });
    Route::get('owl-carousel', function () { return view('pages.advanced-ui.owl-carousel'); });
    Route::get('sweet-alert', function () { return view('pages.advanced-ui.sweet-alert'); });
});

Route::group(['prefix' => 'forms'], function(){
    Route::get('basic-elements', function () { return view('pages.forms.basic-elements'); });
    Route::get('advanced-elements', function () { return view('pages.forms.advanced-elements'); });
    Route::get('editors', function () { return view('pages.forms.editors'); });
    Route::get('wizard', function () { return view('pages.forms.wizard'); });
});

Route::group(['prefix' => 'charts'], function(){
    Route::get('apex', function () { return view('pages.charts.apex'); });
    Route::get('chartjs', function () { return view('pages.charts.chartjs'); });
    Route::get('flot', function () { return view('pages.charts.flot'); });
    Route::get('morrisjs', function () { return view('pages.charts.morrisjs'); });
    Route::get('peity', function () { return view('pages.charts.peity'); });
    Route::get('sparkline', function () { return view('pages.charts.sparkline'); });
});

Route::group(['prefix' => 'tables'], function(){
    Route::get('basic-tables', function () { return view('pages.tables.basic-tables'); });
    Route::get('data-table', function () { return view('pages.tables.data-table'); });
});

Route::group(['prefix' => 'icons'], function(){
    Route::get('feather-icons', function () { return view('pages.icons.feather-icons'); });
    Route::get('flag-icons', function () { return view('pages.icons.flag-icons'); });
    Route::get('mdi-icons', function () { return view('pages.icons.mdi-icons'); });
});

Route::group(['prefix' => 'general'], function(){
    Route::get('blank-page', function () { return view('pages.general.blank-page'); });
    Route::get('faq', function () { return view('pages.general.faq'); });
    Route::get('invoice', function () { return view('pages.general.invoice'); });
    Route::get('profile', function () { return view('pages.general.profile'); });
    Route::get('pricing', function () { return view('pages.general.pricing'); });
    Route::get('timeline', function () { return view('pages.general.timeline'); });
});

Route::group(['prefix' => 'auth'], function(){
    Route::get('login', function () { return view('pages.auth.login'); });
    Route::get('register', function () { return view('pages.auth.register'); });
});

Route::group(['prefix' => 'error'], function(){
    Route::get('404', function () { return view('pages.error.404'); });
    Route::get('500', function () { return view('pages.error.500'); });
});

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

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

//Admin Members

Route::get('admin/mymembers', 'Admin\MyMemberController@index')->name('admin_mymembers');
Route::post('admin/productassign', 'Admin\ProductAssignController@store')->name('admin_productassign');
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



//Dummy transaction
ROute::get('admin/addTransaction' , 'Admin\TransactionController@addTrans');
ROute::post('admin/addTransaction' , 'Admin\TransactionController@store')->name('admin_add_trans');





