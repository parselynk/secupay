<?php

use App\Http\Controllers\TransactionsController;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;


use App\Services\TokenService;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Get serverTime endpoint
 *
 * @note this could have its own Controller but for maintaining simplicity
 * of the task it has been handled directly as route closure.
 */
Route::middleware(['auth:api'])->get('/servertime', function () {
    $serverTime = Carbon::now()->timezone('Europe/Berlin')->toDateTimeString();

    return response()->json(['serverTime' => $serverTime]);
});

Route::prefix('flagbit')->group(function () {
    Route::controller(TransactionsController::class)->middleware(['auth:api'])->group(function () {
        Route::post('/', 'store');
        Route::get('/{transId}', 'show');
        Route::delete('/{transId}', 'destroy');
    });
});
