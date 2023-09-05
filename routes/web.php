<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TradeController;
use App\Models\Setting;
use App\Services\Exchange\ExchangeServiceProvider;
use App\Services\SettingService;
use App\Services\TradeService;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {

    Route::controller(ProfileController::class)->prefix('profile')->group(function () {
        Route::get('/', 'edit')->name('profile.edit');
        Route::patch('/', 'update')->name('profile.update');
        // Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    Route::middleware(['verified'])->group(function () {

        Route::get('dashboard', function () {
            $settings =
                Setting::all('name', 'current_value', 'description')
                ->mapWithKeys(function ($item) {
                    return [$item['name'] => (object) [
                        'value' => $item['current_value'],
                        'description' => $item['description']
                    ]];
                });

            $stats = (object) [
                'base_price' => TradeService::getPairPriceBySymbol(),
                'trading_pair_price' => TradeService::getPairPriceBySymbol(SettingService::getValue('pair_to_trade')),
            ];

            return view('dashboard.index', compact('settings', 'stats'));
        })->name('dashboard');

        Route::controller(SettingController::class)->prefix('settings')->group(function () {
            Route::post('/', 'update')->name('settings.update');
        });

        Route::get('faillogs', function () {
            return view('log');
        })->name('faillogs');

        Route::controller(TradeController::class)->prefix('trade')->group(function () {
            Route::get('/init', 'index')->name('trade.index');
        });

    });
});

require __DIR__ . '/auth.php';
