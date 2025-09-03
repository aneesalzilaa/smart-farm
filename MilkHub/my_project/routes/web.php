<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CowController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\MilkProductionController;
use App\Http\Controllers\CowFeedController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\CowStatisticsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MilkSaleController;
use App\Http\Controllers\MilkSupplierController;
use App\Http\Controllers\MilkSupplierDeliveryController;
use App\Http\Controllers\Dashboard\FarmDailyReportController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('cows')->name('cows.')->group(function () {
    Route::get('/', [CowController::class, 'index'])->name('index');          // عرض قائمة الأبقار
    Route::get('/create', [CowController::class, 'create'])->name('create');  // صفحة إضافة بقرة جديدة
    Route::post('/', [CowController::class, 'store'])->name('store');         // حفظ بقرة جديدة
    Route::get('/{cow}', [CowController::class, 'show'])->name('show');       // عرض تفاصيل بقرة معينة
    Route::get('/{cow}/edit', [CowController::class, 'edit'])->name('edit');  // صفحة تعديل البقرة
    Route::put('/{cow}', [CowController::class, 'update'])->name('update');   // تحديث بيانات البقرة
    Route::delete('/{cow}', [CowController::class, 'destroy'])->name('destroy'); // حذف البقرة
});
Route::resource('feeds', FeedController::class)->names([
    'index' => 'feeds.index',
    'create' => 'feeds.create',
    'store' => 'feeds.store',
    'edit' => 'feeds.edit',
    'update' => 'feeds.update',
    'destroy' => 'feeds.destroy',
    'show' => 'feeds.show',
]);


Route::prefix('milkproductions')->name('milkproductions.')->group(function () {
    Route::get('/', [MilkProductionController::class, 'index'])->name('index');          // عرض قائمة الإنتاج
    Route::get('/create', [MilkProductionController::class, 'create'])->name('create');  // صفحة إضافة إنتاج جديد
    Route::post('/', [MilkProductionController::class, 'store'])->name('store');         // حفظ إنتاج جديد
    Route::get('/milkproduction', [MilkProductionController::class, 'show'])->name('show');       // عرض تفاصيل إنتاج معين
    Route::get('/milkproduction/{milkProduction}', [MilkProductionController::class, 'edit'])->name('edit');  // صفحة تعديل الإنتاج
    Route::put('/milkproduction/{milkProduction}', [MilkProductionController::class, 'update'])->name('update');   // تحديث بيانات الإنتاج
    Route::delete('/milkproduction/{id}', [MilkProductionController::class, 'destroy'])->name('destroy');
    Route::get('/milkproductions/daily', [MilkProductionController::class, 'dailyProduction'])->name('daily');

});
Route::prefix('cowfeeds')->as('cowfeeds.')->group(function () {
    Route::get('/', [CowFeedController::class, 'index'])->name('index');
    Route::get('/create', [CowFeedController::class, 'create'])->name('create');
    Route::post('/', [CowFeedController::class, 'store'])->name('store');
    Route::get('/{cowFeed}/edit', [CowFeedController::class, 'edit'])->name('edit');
    Route::put('/{cowFeed}', [CowFeedController::class, 'update'])->name('update');
    Route::delete('/{cowFeed}', [CowFeedController::class, 'destroy'])->name('destroy');
    Route::get('cowfeeds/daily', [CowFeedController::class, 'daily'])->name('daily');
});
Route::prefix('pricing')->name('pricings.')->group(function () {

    Route::get('/index', [PricingController::class, 'index'])->name('index');
    Route::get('/create', [PricingController::class, 'create'])->name('create');
    Route::post('/', [PricingController::class, 'store'])->name('store');
    Route::get('show/{id}', [PricingController::class, 'show'])->name('show');
    Route::get('edit/{id}/edit', [PricingController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PricingController::class, 'update'])->name('update');
    Route::delete('/{id}', [PricingController::class, 'destroy'])->name('destroy');
});

Route::get('/cow/statistics', [CowStatisticsController::class, 'showStatistics'])->name('cow.statistics');

Route::prefix('customers')->as('customers.')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('index');
    Route::get('/create', [CustomerController::class, 'create'])->name('create');
    Route::post('/', [CustomerController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [CustomerController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CustomerController::class, 'update'])->name('update');
    Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('destroy');
});

Route::prefix('dashboard/milksales')->name('milksales.')->group(function () {
    Route::get('/', [MilkSaleController::class, 'index'])->name('index');
    Route::get('/create', [MilkSaleController::class, 'create'])->name('create');
    Route::post('/', [MilkSaleController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [MilkSaleController::class, 'edit'])->name('edit'); // تأكد من وجود دالة edit
    Route::put('/{id}', [MilkSaleController::class, 'update'])->name('update');
    Route::delete('/{id}', [MilkSaleController::class, 'destroy'])->name('destroy');
});

Route::prefix('dashboard/milk_suppliers')->name('milk_suppliers.')->group(function () {
    Route::get('/', [MilkSupplierController::class, 'index'])->name('index');
    Route::get('/create', [MilkSupplierController::class, 'create'])->name('create');
    Route::post('/', [MilkSupplierController::class, 'store'])->name('store');
    Route::get('/{milkSupplier}/edit', [MilkSupplierController::class, 'edit'])->name('edit');
    Route::put('/{milkSupplier}', [MilkSupplierController::class, 'update'])->name('update');
    Route::delete('/{milkSupplier}', [MilkSupplierController::class, 'destroy'])->name('destroy');
    Route::get('/dashboard/milk_suppliers/report', [MilkSupplierController::class, 'report'])->name('report');

});
Route::prefix('dashboard/milk_supplier_deliveries')->name('milk_supplier_deliveries.')->group(function () {
    Route::get('/', [MilkSupplierDeliveryController::class, 'index'])->name('index');
    Route::get('/create', [MilkSupplierDeliveryController::class, 'create'])->name('create');
    Route::post('/', [MilkSupplierDeliveryController::class, 'store'])->name('store');
    Route::get('/{milkSupplierDelivery}/edit', [MilkSupplierDeliveryController::class, 'edit'])->name('edit');
    Route::put('/{milkSupplierDelivery}', [MilkSupplierDeliveryController::class, 'update'])->name('update');
    Route::delete('/{milkSupplierDelivery}', [MilkSupplierDeliveryController::class, 'destroy'])->name('destroy');
});


Route::get('/dashboard/daily-report', [FarmDailyReportController::class, 'index'])
    ->name('reports.daily');

    Route::get('dashboard/milksales/reports', [MilkSaleController::class, 'report'])->name('milksales.report');

Route::post('/cowfeeds/feed-all', [CowFeedController::class, 'feedAllCows'])->name('cowfeeds.feedAllCows');
require __DIR__.'/auth.php';
