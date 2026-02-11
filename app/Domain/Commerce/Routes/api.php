<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Commerce\MobileCommerceController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/commerce')->name('mobile.commerce.')
    ->middleware(['auth:sanctum', 'check.token.expiration'])
    ->group(function () {
        Route::get('/merchants', [MobileCommerceController::class, 'merchants'])
            ->middleware('api.rate_limit:query')
            ->name('merchants');
        Route::post('/parse-qr', [MobileCommerceController::class, 'parseQr'])
            ->middleware('api.rate_limit:query')
            ->name('parse-qr');
        Route::post('/payment-requests', [MobileCommerceController::class, 'createPaymentRequest'])
            ->middleware('transaction.rate_limit:payment_intent')
            ->name('payment-requests');
        Route::post('/payments', [MobileCommerceController::class, 'processPayment'])
            ->middleware('transaction.rate_limit:payment_intent')
            ->name('payments');
        Route::post('/generate-qr', [MobileCommerceController::class, 'generateQr'])
            ->middleware('api.rate_limit:query')
            ->name('generate-qr');
    });
