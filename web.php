<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PortalController;
use App\Http\Middleware\Admin;
use App\Models\ManageKoran;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Exp;

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

Route::get('/', [PortalController::class, 'index']);

Auth::routes();

Route::get('/admin/sample-1', [AdminController::class, 'samplePage1'])->name('samplePage1');

Route::get('/admin/sample-2', [AdminController::class, 'samplePage2'])->name('samplePage2');

Route::get('/home', [App\Http\Controllers\AdminController::class, 'index'])->name('home');




Route::group(['middleware' => 'admin'], function () {

    // KORAN
    // ONLY FOR ADMIN

    Route::get('/admin/koran', [AdminController::class, 'koran'])->name('koran');

    Route::post('/admin/koran/add', [AdminController::class, 'tambahKoran'])->name('tambahKoran');

    Route::post('/admin/koran/edit/{id_koran}', [AdminController::class, 'editKoran'])->name('editKoran');

    Route::get('/admin/koran/delete/{id_koran}', [AdminController::class, 'deleteKoran'])->name('deleteKoran');

    Route::post('/admin/koran/import', [ImportController::class, 'importKoran'])->name('importKoran');


    // CUSTOMERS
    // ONLY FOR ADMIN

    Route::get('/admin/customer', [AdminController::class, 'customers'])->name('customers');

    Route::get('/admin/customers/request-orders', [AdminController::class, 'reqOrder'])->name('reqOrder');

    Route::get('/admin/customers/accept/{id_cust}', [AdminController::class, 'accOrder'])->name('accOrder');

    Route::get('/admin/customers/decline/{id_cust}', [AdminController::class, 'decOrder'])->name('decOrder');

    Route::post('/admin/customers/import', [ImportController::class, 'importCustomer'])->name('importCustomer');

    Route::get('/admin/customers/add', [AdminController::class, 'addCust'])->name('addCust');

    Route::post('/admin/customers/add', [AdminController::class, 'createCust'])->name('createCust');

    Route::get('/admin/customers/edit/{id_cust}', [AdminController::class, 'editCust'])->name('editCust');

    Route::post('/admin/customers/edit/{id_cust}', [AdminController::class, 'updateCust']);

    Route::get('/admin/customers/delete/{id_cust}', [AdminController::class, 'deleteCust']);

    Route::get('/admin/customers/export-pdf/{tgl_awal}/{tgl_akhir}', [ExportController::class, 'exportpdfKoranlangganan'])->name('exportpdfKoranlangganan');


    // MANAGEMENT KORAN
    // ONLY FOR ADMIN

    Route::get('/admin/koran-management', [AdminController::class, 'koranManage'])->name('koranManage');

    Route::get('/admin/koran-management/add-data', [AdminController::class, 'addKoranManage'])->name('addKoranManage');

    Route::post('/admin/koran-management/add-data/process', [AdminController::class, 'createKoranManage'])->name('createKoranManage');

    Route::get('/admin/koran-management/edit-data/{id_input}', [AdminController::class, 'editKoranManage'])->name('editKoranManage');

    Route::post('/admin/koran-management/edit-data/{id_input}', [AdminController::class, 'updateKoranManage'])->name('updateKoranManage');

    Route::post('/admin/koran-management/import-data', [ImportController::class, 'importKoranHarian'])->name('importKoranHarian');

    Route::get('/admin/koran-management/delete/{id}', [AdminController::class, 'deleteKoranHarian']);

    //PROFILE
    //FOR ADMIN
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('profile');

    Route::post('/admin/profile/{id}', [AdminController::class, 'updateProfil']);

    //PAKET 
    //FOR ADMIN
    Route::get('/admin/paket', [AdminController::class, 'paket'])->name('paket');

    Route::post('/admin/paket/tambah', [AdminController::class, 'addPaket'])->name('addPaket');

    Route::post('/admin/paket/edit/{id_paket}', [AdminController::class, 'editPaket'])->name('editPaket');

    Route::get('/admin/paket/delete/{id_paket}', [AdminController::class, 'deletePaket'])->name('deletePaket');

    //TAGIHAN
    Route::get('/admin/tagihan', [AdminController::class, 'tagihan'])->name('tagihan');

    Route::post('/admin/tagihan/send', [MailController::class, 'kirimTagihan'])->name('kirimTagihan');
});


Route::group(['middleware' => 'manager'], function () {

    // Route::get('/manager', [ManagerController::class, 'index'])->name('mgHome');

    // MANAGEMENET USERS
    Route::get('/manager/users', [ManagerController::class, 'getUsers'])->name('getUsers');

    Route::post('/manager/users/add', [ManagerController::class, 'addUsers'])->name('addUsers');

    route::get('/manager/users/delete/{id}', [ManagerController::class, 'destroyUser'])->name('destroyUser');

    Route::post('/manager/users/edit/{id}', [ManagerController::class, 'editUser']);

    //KORAN
    Route::get('/manager/koran', [ManagerController::class, 'getKoran'])->name('getKoran');

    //CUSTOMER
    Route::get('/manager/customer', [ManagerController::class, 'getCusts'])->name('getCusts');

    //DATA KORAN HARIAN
    Route::get('/manager/data-koran-harian', [ManagerController::class, 'getKoranHarian'])->name('getKoranHarian');

    //PROFILE
    //FOR MANAGER
    Route::get('/manager/profile', [ManagerController::class, 'profile'])->name('mgProfile');

    Route::post('/manager/profile/{id}', [ManagerController::class, 'updateProfil']);

    //PAKET
    Route::get('/manager/paket', [ManagerController::class, 'getPaket'])->name('getPaket');

    // REQUEST ORDER 
    Route::get('/manager/request-order', [ManagerController::class, 'getReqOrder'])->name('getReqOrder');
});


// NOTIFICATION
// MARK AS READ

route::get('/read-notify/{notifiable_id}', [ManagerController::class, 'readNotify']);

route::get('/admin/mark-as-read', [AdminController::class, 'markAsRead'])->name('readNotify');

// CUSTOMER ORDER
// UNTUK HALAMAN PORTAL DEPAN / LANDING PAGE

Route::get('/orders', [PortalController::class, 'store'])->name('order');

Route::post('/orders/add', [PortalController::class, 'order'])->name('addOrder');



// EXPORT DATA

Route::get('/admin/customers/export-pdf/{tgl_awal}/{tgl_akhir}', [ExportController::class, 'exportpdfKoranlangganan'])->name('exportpdfKoranlangganan');

Route::get('/admin/manage-koran/export-pdf/{tgl_awal}/{tgl_akhir}', [ExportController::class, 'exportpdfKoranMasuk'])->name('exportpdfKoranMasuk');

Route::get('/admin/koran-management/export-excel', [ExportController::class, 'exportKoranHariantoExcel'])->name('exportKoranHariantoExcel');

Route::get('/admin/koran/export-to-excel', [ExportController::class, 'exportKoran'])->name('exportKoran');

Route::get('/admin/koran/export-pdf', [ExportController::class, 'exportKoranPdf'])->name('exportKoranPdf');

Route::get('/admin/customer/export-to-excel', [ExportController::class, 'exportCustomer'])->name('exportCustomer');

Route::get('/admin/paket/export-to-excel', [ExportController::class, 'exportPaket'])->name('exportPaket');

Route::get('/admin/paket/export-to-pdf', [ManagerController::class, 'getAllPaketPdf'])->name('getAllPaketPdf');
