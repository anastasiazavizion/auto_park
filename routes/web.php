<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CarController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\DashboardController;
Route::get('/', function () {
return redirect(route('dashboard'));
});

Route::middleware('admin')->group(function (){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('cars',CarController::class);
    Route::resource('drivers',DriverController::class);
    Route::resource('orders',OrderController::class);

    Route::post('/order/checkout', [\App\Http\Controllers\CheckoutController::class, 'checkout'])->name('order.checkout');
    Route::post('/order/checkout/{order}', [\App\Http\Controllers\CheckoutController::class, 'checkoutOrder'])->name('order.checkoutOrder');

    Route::get('/checkout/success', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/fail', [\App\Http\Controllers\CheckoutController::class, 'fail'])->name('checkout.fail');

});


Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('language.locale');


Route::get('/locale/translations', [LocaleController::class, 'translations'])->name('locale.translations');
Route::post('/locale/{locale}', [LocaleController::class, 'store'])->name('locale.store');
Route::get('/locale/current', [LocaleController::class, 'currentLocale'])->name('locale.current');

Route::post('/webhook/stripe', [\App\Http\Controllers\CheckoutController::class, 'webhook'])->name('webhook.stripe');

require __DIR__.'/auth.php';
