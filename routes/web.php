<?php

//require 'vendor/autoload.php';
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


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
Route::middleware(['auth','status'])->group(function (){
    Route::get('/', function () {
        return view('index');
    });
    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('/sections','SectionController');
    Route::resource('/products','ProductController');
    Route::resource('/roles', 'RoleController');

    Route::group(['middleware' => ['can:users']], function () {
        Route::resource('/users','UsersController');
    });
    Route::group(['middleware' => ['can:invoices']], function () {
        Route::resource('/invoices','InvoiceController');
    });

    Route::get('/section/{id}', 'InvoiceController@getproducts');
    Route::post('/down/{invoice_number}/{file_name}','InvoiceAttachmentController@download')->name('download');
    Route::get('/delete_file/{invoice_number}/{file_name}','InvoiceAttachmentController@delete')->name('delete');
    Route::POST('/addAttachment','InvoiceAttachmentController@addAttachment')->name('addAttachment');

    Route::post('/archive/{id}','InvoiceController@archive')->name('archive');
    Route::get('/archive_view','InvoiceController@archive_view')->name('archive_view');
    Route::get('/sendEmail','InvoiceController@email')->name('email');
    Route::post('/archive_restore/{id}','InvoiceController@archive_restore')->name('archive_restore');


    Route::get('/status_show/{id}','InvoiceController@status_show')->name('status_show');
    Route::POST('/status_update/{id}','InvoiceController@status_update')->name('status_update');
    Route::get('/paid','InvoiceController@paid')->name('paid');
    Route::get('/partial','InvoiceController@partial')->name('partial');
    Route::get('/permissions','UsersController@permissions')->name('permissions');
    Route::get('/unpaid','InvoiceController@unpaid')->name('unpaid');
    Route::get('/print/{id}','InvoiceController@print')->name('print');
    Route::get('/export', 'InvoiceController@export');
    Route::get('/reports/invoices', 'InvoiceController@reportInvoice');
    Route::get('/reports/customers', 'InvoiceController@reportCustomers');
    Route::get('/reportInvoiceRequest', 'InvoiceController@reportInvoiceRequest');
});




Auth::routes(['register' => false]);











Route::get('/activate',function (){
    return view('activate');
})->name('activate');



//Route::get('/markUp',function (){
//    return view('invoices.test');
//});


Route::get('/{page}', 'AdminController@index');
