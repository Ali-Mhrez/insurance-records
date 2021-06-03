<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CashAndRemittanceInsuranceController;
use App\Http\Controllers\GuranteeController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\GenerateReportsController;
use App\Http\Controllers\FguaranteeController;
use App\Http\Controllers\FcheckController;
use App\Http\Controllers\FpaymentController;
use App\Http\Controllers\UpdatePasswordController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/tt', function () {
    return view('tt');
});

Route::get('/', function () {
    return view('welcome');
})->name("welcome")->middleware('global','auth');

Route::get('/reports', function () {
    return view('master.generate_reports');
})->name("master.test")->middleware('auth');

Route::get('/test', function () {
    return view('master.test');
})->name("master.test")->middleware('auth');
//Route::get('/administrator/new', function () {
//    return redirect()->route('welcome');
//})->middleware('global');

//--------------------------------- UserController-------------------------------------

Route::group(['prefix' => 'admin', 'middleware' => ['auth','role:administrator']], function() {

Route::get('/newUser', [UserController::class, 'registerForm'])->name('new-user-form');

Route::get('/SuccessRegister', [UserController::class, 'create'])->name('new-user');

Route::get('/SuccessRegister/{id}', [UserController::class, 'show'])->name('new-user-show');

Route::get('/userList', [UserController::class, 'index'])->name('users.list');

Route::get('/userEdit/{id}', [UserController::class, 'edit'])->name('user.edit');

Route::get('/userUpdate/{id}', [UserController::class, 'update'])->name('user.update');

Route::get('/userDelete/{id}', [UserController::class, 'delete'])->name('user.delete');
});

//------------------------------PasswordController------------------------------
Route::group(['middleware' => ['auth']], function() {

Route::get('/editPassword', [UpdatePasswordController::class, 'index'])->name('update-password-form');

Route::get('/updatePassword', [UpdatePasswordController::class, 'update'])->name('update-password');

// ----------------------------- Reportscontroller--------------------------------------------------

Route::get('/reports', [GenerateReportsController::class,'index'])->name('reports.index');

Route::get('/generate_detailed_reports', [GenerateReportsController::class,'detailed_reports'])->name('reports.detailed_reports');

Route::get('/generate_summary_reports', [GenerateReportsController::class,'summary_reports'])->name('reports.summary_reports');
});

// --------------------BankController--------------------------------------------

Route::group(['prefix' => 'banks', 'middleware' => ['auth','role:administrator']], function() {

Route::get('/', [BankController::class, 'index'])->name('bank.list');

Route::get('/create', [BankController::class, 'store'])->name('bank.store');

Route::post('/update', [BankController::class, 'update'])->name('bank.update');

Route::get('/delete/{id}', [BankController::class, 'delete'])->name('bank.delete');
});

// --------------------CashAndRemittanceInsuranceController----------------------

Route::group([ 'middleware' => ['permission:initial_records-read']], function() {

Route::get('/payments', [CashAndRemittanceInsuranceController::class, 'index'])->name('payment.list')->middleware('permission:initial_records-search');

Route::get('/payment/create', [CashAndRemittanceInsuranceController::class, 'create'])->name('payment.create')->middleware('permission:initial_records-input');

Route::get('/payment/store', [CashAndRemittanceInsuranceController::class, 'store'])->name('payment.store')->middleware('permission:initial_records-input');

Route::get('/payment/show/{id}', [CashAndRemittanceInsuranceController::class, 'show'])->name('payment.show')->middleware('permission:initial_records-search');

Route::get('/payment/releaseForm/{id}', [CashAndRemittanceInsuranceController::class, 'releaseForm'])->name('payment.releaseForm')->middleware('permission:initial_records-input');

Route::get('/payment/release/{id}', [CashAndRemittanceInsuranceController::class, 'release'])->name('payment.release')->middleware('permission:initial_records-input');

Route::get('/payment/requiseForm/{id}', [CashAndRemittanceInsuranceController::class, 'requiseForm'])->name('payment.requiseForm')->middleware('permission:initial_records-input');

Route::get('/payment/requise/{id}', [CashAndRemittanceInsuranceController::class, 'requise'])->name('payment.requise')->middleware('permission:initial_records-input');

Route::get('/payment/edit/{id}', [CashAndRemittanceInsuranceController::class, 'edit'])->name('payment.edit')->middleware('permission:initial_records-edit');

Route::get('/payment/update/{id}', [CashAndRemittanceInsuranceController::class, 'update'])->name('payment.update')->middleware('permission:initial_records-edit');

Route::get('/payments/find/{id}', [CashAndRemittanceInsuranceController::class, 'find'])->middleware('permission:initial_records-seacrh');

// ----------------------------------------------GuaranteeController----------------------------------------------

Route::get('/guarantees', [GuranteeController::class, 'index'])->name('guarantee.list')->middleware('permission:initial_records-search');

Route::get('/guarantee/create', [GuranteeController::class, 'create'])->name('guarantee.create')->middleware('permission:initial_records-input');

Route::get('/guarantee/store', [GuranteeController::class, 'store'])->name('guarantee.store')->middleware('permission:initial_records-input');

Route::get('/guarantee/extend_form/{id}', [GuranteeController::class, 'extendForm'])->name('guarantee.extendForm')->middleware('permission:initial_records-input');

Route::get('/guarantee/extend/{id}', [GuranteeController::class, 'extend'])->name('guarantee.extend')->middleware('permission:initial_records-input');

Route::get('/guarantee/release_from/{id}', [GuranteeController::class, 'releaseForm'])->name('guarantee.releaseForm')->middleware('permission:initial_records-input');

Route::get('/guarantee/release/{id}', [GuranteeController::class, 'release'])->name('guarantee.release')->middleware('permission:initial_records-input');

Route::get('/guarantee/monetizeForm/{id}', [GuranteeController::class, 'monetizeForm'])->name('guarantee.monetizeForm')->middleware('permission:initial_records-input');

Route::get('/guarantee/monetize/{id}', [GuranteeController::class, 'monetize'])->name('guarantee.monetize')->middleware('permission:initial_records-input');

Route::get('/guarantee/requiseForm/{id}', [GuranteeController::class, 'requiseForm'])->name('guarantee.requiseForm')->middleware('permission:initial_records-input');

Route::get('/guarantee/requise/{id}', [GuranteeController::class, 'requise'])->name('guarantee.requise')->middleware('permission:initial_records-input');

Route::get('/guarantee/edit/{id}', [GuranteeController::class, 'edit'])->name('guarantee.edit')->middleware('permission:initial_records-edit');

Route::get('/guarantee/update/{id}', [GuranteeController::class, 'update'])->name('guarantee.update')->middleware('permission:initial_records-edit');

Route::get('/guarantee/show/{id}', [GuranteeController::class, 'show'])->name('guarantee.show')->middleware('permission:initial_records-search');


// ----------------------------------------------CheckController----------------------------------------------

Route::get('/checks', [CheckController::class, 'index'])->name('list_checks')->middleware('permission:initial_records-search');

Route::get('/check/create', [CheckController::class, 'create'])->name('create_check')->middleware('permission:initial_records-input');

Route::get('/check/store', [CheckController::class, 'store'])->name('check.store')->middleware('permission:initial_records-input');

Route::get('/check/releaseForm/{id}', [CheckController::class, 'releaseForm'])->name('check.releaseForm')->middleware('permission:initial_records-input');

Route::get('/check/release/{id}', [CheckController::class, 'release'])->name('check.release')->middleware('permission:initial_records-input');

Route::get('/check/requiseForm/{id}', [CheckController::class, 'requiseForm'])->name('check.requiseForm')->middleware('permission:initial_records-input');

Route::get('/check/requise/{id}', [CheckController::class, 'requise'])->name('check.requise')->middleware('permission:initial_records-input');

Route::get('/check/edit/{id}', [CheckController::class, 'edit'])->name('check.edit')->middleware('permission:initial_records-edit');

Route::get('/check/find/{id}', [CheckController::class, 'find'])->name('check.find')->middleware('permission:initial_records-search');

Route::get('/check/update/{id}', [CheckController::class, 'update'])->name('check.update')->middleware('permission:initial_records-edit');

Route::get('/check/show/{id}', [CheckController::class, 'show'])->name('check.show')->middleware('permission:initial_records-search');

});

Route::group([ 'middleware' => ['permission:final_records-read']], function() {

// ----------------------------------------------FguaranteeController----------------------------------------------

Route::get('/fguarantees', [FguaranteeController::class, 'index'])->name('fguarantee.list')->middleware('permission:final_records-search');

Route::get('/fguarantee/create', [FguaranteeController::class, 'create'])->name('fguarantee.create')->middleware('permission:final_records-input');

Route::get('/fguarantee/store', [FguaranteeController::class, 'store'])->name('fguarantee.store')->middleware('permission:final_records-input');

Route::get('/fguarantee/extend_form/{id}', [FguaranteeController::class, 'extendForm'])->name('fguarantee.extendForm')->middleware('permission:final_records-input');

Route::get('/fguarantee/extend/{id}', [FguaranteeController::class, 'extend'])->name('fguarantee.extend')->middleware('permission:final_records-input');

Route::get('/fguarantee/release_from/{id}', [FguaranteeController::class, 'releaseForm'])->name('fguarantee.releaseForm')->middleware('permission:final_records-input');

Route::get('/fguarantee/release/{id}', [FguaranteeController::class, 'release'])->name('fguarantee.release')->middleware('permission:final_records-input');

Route::get('/fguarantee/monetizeForm/{id}', [FguaranteeController::class, 'monetizeForm'])->name('fguarantee.monetizeForm')->middleware('permission:final_records-input');

Route::get('/fguarantee/monetize/{id}', [FguaranteeController::class, 'monetize'])->name('fguarantee.monetize')->middleware('permission:final_records-input');

Route::get('/fguarantee/requiseForm/{id}', [FguaranteeController::class, 'requiseForm'])->name('fguarantee.requiseForm')->middleware('permission:final_records-input');

Route::get('/fguarantee/requise/{id}', [FguaranteeController::class, 'requise'])->name('fguarantee.requise')->middleware('permission:final_records-input');

Route::get('/fguarantee/edit/{id}', [FguaranteeController::class, 'edit'])->name('fguarantee.edit')->middleware('permission:final_records-edit');

Route::get('/fguarantee/update/{id}', [FguaranteeController::class, 'update'])->name('fguarantee.update')->middleware('permission:final_records-edit');

Route::get('/fguarantee/show/{id}', [FguaranteeController::class, 'show'])->name('fguarantee.show')->middleware('permission:final_records-search');

// ----------------------------------------------FpaymentController----------------------------------------------

Route::get('/fpayments', [FpaymentController::class, 'index'])->name('fpayment.list')->middleware('permission:final_records-search');

Route::get('/fpayment/create', [FpaymentController::class, 'create'])->name('fpayment.create')->middleware('permission:final_records-input');

Route::get('/fpayment/store', [FpaymentController::class, 'store'])->name('fpayment.store')->middleware('permission:final_records-input');


Route::get('/fpayment/release_from/{id}', [FpaymentController::class, 'releaseForm'])->name('fpayment.releaseForm')->middleware('permission:final_records-input');

Route::get('/fpayment/release/{id}', [FpaymentController::class, 'release'])->name('fpayment.release')->middleware('permission:final_records-input');

Route::get('/fpayment/requiseForm/{id}', [FpaymentController::class, 'requiseForm'])->name('fpayment.requiseForm')->middleware('permission:final_records-input');

Route::get('/fpayment/requise/{id}', [FpaymentController::class, 'requise'])->name('fpayment.requise')->middleware('permission:final_records-input');

Route::get('/fpayment/edit/{id}', [FpaymentController::class, 'edit'])->name('fpayment.edit')->middleware('permission:final_records-edit');

Route::get('/fpayment/update/{id}', [FpaymentController::class, 'update'])->name('fpayment.update')->middleware('permission:final_records-edit');

Route::get('/fpayment/show/{id}', [FpaymentController::class, 'show'])->name('fpayment.show')->middleware('permission:final_records-search');

//------------------------------------------FcheckController-----------------------------------------------------

Route::get('/fchecks', [FcheckController::class, 'index'])->name('fcheck.list')->middleware('permission:final_records-search');

Route::get('/fcheck/create', [FcheckController::class, 'create'])->name('fcheck.create')->middleware('permission:final_records-input');

Route::get('/fcheck/store', [FcheckController::class, 'store'])->name('fcheck.store')->middleware('permission:final_records-input');

Route::get('/fcheck/renew_form/{id}', [FcheckController::class, 'renewForm'])->name('fcheck.renewForm')->middleware('permission:final_records-input');

Route::get('/fcheck/renew/{id}', [FcheckController::class, 'renew'])->name('fcheck.renew')->middleware('permission:final_records-input');

Route::get('/fcheck/release_from/{id}', [FcheckController::class, 'releaseForm'])->name('fcheck.releaseForm')->middleware('permission:final_records-input');

Route::get('/fcheck/release/{id}', [FcheckController::class, 'release'])->name('fcheck.release')->middleware('permission:final_records-input');

Route::get('/fcheck/requiseForm/{id}', [FcheckController::class, 'requiseForm'])->name('fcheck.requiseForm')->middleware('permission:final_records-input');

Route::get('/fcheck/requise/{id}', [FcheckController::class, 'requise'])->name('fcheck.requise')->middleware('permission:final_records-input');

Route::get('/fcheck/edit/{id}', [FcheckController::class, 'edit'])->name('fcheck.edit')->middleware('permission:final_records-edit');

Route::get('/fcheck/update/{id}', [FcheckController::class, 'update'])->name('fcheck.update')->middleware('permission:final_records-edit');

Route::get('/fcheck/show/{id}', [FcheckController::class, 'show'])->name('fcheck.show')->middleware('permission:final_records-search');

});


Auth::routes();



