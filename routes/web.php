<?php

use App\Facades\Settings\SettingsFacade;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GenericsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\PreDiscountController;
use App\Http\Controllers\PriscriptionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariationController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ScrapController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;
use App\Mail\CustomerReport;
use App\Mail\DueClearReminder;
use App\Mail\DuePaidMail;
use App\Mail\MonthlyDueReport;
use App\Mail\OrderConfirmationMail;
use App\Mail\PurchasesMailForShopOwner;
use App\Models\Customer;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ScrapController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Auth::routes();
Route::get('snapshop/customer/delete', [CustomerController::class, 'customerDelete'])->name('customer.delete');
Route::middleware(['auth', 'role:2'])->group(function () {
    Route::get('/snapshop/customer/Dashaboard', [CustomerController::class, 'dashboardForCustomer'])->name('customer.dashboard');
    Route::post('/customer/Dashaboard', [CustomerController::class, 'customerInfoDelete'])->name('customer.infoDelete');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');


    Route::group(
        [
            'as' => 'orders.',
            'prefix' => 'orders',
            'controller' => OrderController::class
        ],
        function () {
            Route::get('list', 'index')->name('index');
            Route::post('pay', 'duepay')->name('due.pay');
            Route::post('mark-as-pay', 'mark_pay')->name('mark.pay');
            Route::get('mark-as-delivered/{order}', 'mark_delivered')->name('mark.delivered');
            Route::get('invoice/{order}', 'invoice')->name('invoice');
        }
    );
    Route::group(
        [
            'as' => 'products.',
            'prefix' => 'products',
            'controller' => ProductController::class
        ],
        function () {
            Route::get('edit/{product}', 'edit')->name('edit');
            // Route::get('create', 'create')->name('create');
            Route::get('create-or-edit/{product?}', 'createOrEdit')->name('createOrEdit');
            Route::post('duplicate', 'duplicateProduct')->name('duplicate');
            Route::post('save/{product?}', 'save')->name('save');
            Route::get('list', 'index')->name('index');
            Route::delete('delete/{product}', 'destroy')->name('delete');
        }
    );

    Route::resource('generics', GenericsController::class);
    Route::resource('customers', CustomerController::class);
    Route::get('customers/shifts/{customer}', [CustomerController::class, 'customerShifts'])->name('customers.shifts');
    Route::post('deposite-full/{user}', [CustomerController::class, 'deposite_full'])->name('deposite.full');
    // Route::get('/invoice/{customer}', [CustomerController::class, 'invoice'])->name('invoice');
    Route::get('/point-of-sale', [POSController::class, 'index'])->name('pos');
    // Route::view('react-component', 'react-component');

    Route::resource('purchase', PurchaseController::class)->names('purchase');
    Route::resource('units', UnitController::class)->names('units');
    Route::resource('suppliers', SupplierController::class)->parameters(['suppliers' => 'supplier'])->names('suppliers');


    Route::resource('categories', CategoryController::class);
    Route::resource('settings', SettingController::class);
    Route::resource('priscription', PriscriptionController::class);

    Route::post('change-password', [SettingController::class, 'changePassword'])->name('settings.change-password');

    Route::get('/get-chart-data', [OrderController::class, 'getChartData']);
    Route::get('/get-chart-data-month', [OrderController::class, 'getChartDataMonth']);
    Route::post('/customer/store', [POSController::class, 'customerStore'])->name('customer.store');
    Route::get('purchase/invoice/{purchase}', [PurchaseController::class, 'invoice'])->name('purchase.invoice');

    Route::get('reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::get('send-reports/{customer}', [ReportsController::class, 'send_report'])->name('reports.send');
    Route::get('scrap', [ScrapController::class, 'scrap'])->name('scrap');
    Route::resource('roles', RoleController::class);
    Route::resource('pre-discounts', PreDiscountController::class);

    Route::group(['controller' => ProductVariationController::class], function () {
        Route::post('store-attribute', 'storeAttribue')->name('store.attribute');
        Route::post('update-attribute', 'updateAttribue')->name('update.attribute');
        Route::get('new-variation/{product}', 'newVariation')->name('new.variation');
        Route::post('update-variation/{product}', 'updateVariation')->name('update.variation');
        Route::get('delete-meta/{product}', 'deleteProductMeta')->name('delete.product.meta');
        Route::get('delete-attribute/{attribute}', 'deleteProductAttribute')->name('delete.product.attribute');
        Route::get('copy-product/{product}', 'CopyProduct')->name('copy.product');
        Route::get('create-all-variation-from-attribute/{product}', 'create_all_variation')->name('create.all.variation');
        Route::get('delete-all-child/{product}', 'delete_all_child')->name('delete.all.child');
    });

    Route::get('/test-email', function () {
        $customers = User::where('role_id', 2)->where(function ($query) {
            $query->whereNull('last_reminder_date')
                ->orWhere('last_reminder_date', '<=', now()->subDays(30));
        })
            ->whereHas('orders', function ($query) {
                $query->where('due', '>', 0);
            })
            ->whereNotNull('email')
            ->take(10)
            ->get();
        foreach ($customers as $customer) {

            $orders = $customer->orders()->where('due', '>', 0)->get();
            if ($customer->email) {
                return (new DueClearReminder($orders, $customer));
                $customer->update(['last_reminder_date' => now()]);
            }
        }
    });
});

