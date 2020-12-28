<?php

//require 'vendor/autoload.php';
use App\Invoice;
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

Route::redirect('/','/en');
Route::group(['prefix'=>'{lang}'], function () {
    Auth::routes(['register' => false]);
    Route::middleware(['auth','status'])->group(function () {
        Route::get('/','HomeController@index');
        Route::get('/index','HomeController@index');
    });



        //

//
        Route::resource('/sections','SectionController');
        Route::resource('/products','ProductController');
        Route::resource('/roles', 'RoleController');
//
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

        Route::post('/reportInvoiceRequest', 'InvoiceController@reportInvoiceRequests')->name('reportInvoiceRequests');

        Route::get('/reports/invoices', 'InvoiceController@reportInvoice');
        Route::get('/reports/customers', 'InvoiceController@reportCustomers');
        Route::get('/reports/customersQuery', 'InvoiceController@reportCustomersQuery')->name('customers');
        Route::get('/notification/details/{id}', 'InvoiceController@notificationDetails')->name('notificationDetails');

        Route::get('/markAsRead', function (){
            $user = auth()->user();
            foreach ($user->unreadNotifications as $notification) {
                $notification->markAsRead();
            }
            return redirect('index');
        });
});














Route::get('/activate',function (){
    return view('activate');
})->name('activate');

Route::get('/{page}', 'AdminController@index');
