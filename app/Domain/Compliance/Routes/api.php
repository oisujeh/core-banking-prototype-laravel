<?php

declare(strict_types=1);

use App\Http\Controllers\Api\ComplianceAlertController;
use App\Http\Controllers\Api\ComplianceCaseController;
use App\Http\Controllers\Api\GdprController;
use App\Http\Controllers\Api\KycController;
use Illuminate\Support\Facades\Route;

// Compliance and KYC endpoints
Route::middleware('auth:sanctum', 'check.token.expiration')->prefix('compliance')->group(function () {
    // Compliance alerts
    Route::prefix('alerts')->group(function () {
        Route::get('/', [ComplianceAlertController::class, 'index']);
        Route::post('/', [ComplianceAlertController::class, 'create']);
        Route::get('/statistics', [ComplianceAlertController::class, 'statistics']);
        Route::get('/trends', [ComplianceAlertController::class, 'trends']);
        Route::get('/{alert}', [ComplianceAlertController::class, 'show']);
        Route::put('/{alert}', [ComplianceAlertController::class, 'update']);
        Route::delete('/{alert}', [ComplianceAlertController::class, 'destroy']);
        Route::post('/{alert}/assign', [ComplianceAlertController::class, 'assign']);
        Route::post('/{alert}/resolve', [ComplianceAlertController::class, 'resolve']);
        Route::post('/{alert}/escalate', [ComplianceAlertController::class, 'escalate']);
        Route::post('/{alert}/link', [ComplianceAlertController::class, 'link']);
        Route::post('/{alert}/notes', [ComplianceAlertController::class, 'addNote']);
    });

    // Compliance cases
    Route::prefix('cases')->group(function () {
        Route::get('/', [ComplianceCaseController::class, 'index']);
        Route::post('/', [ComplianceCaseController::class, 'create']);
        Route::get('/{case}', [ComplianceCaseController::class, 'show']);
        Route::put('/{case}', [ComplianceCaseController::class, 'update']);
        Route::delete('/{case}', [ComplianceCaseController::class, 'destroy']);
        Route::post('/{case}/status', [ComplianceCaseController::class, 'updateStatus']);
        Route::post('/{case}/notes', [ComplianceCaseController::class, 'addNote']);
        Route::post('/{case}/documents', [ComplianceCaseController::class, 'addDocument']);
    });

    // KYC endpoints
    Route::prefix('kyc')->group(function () {
        Route::get('/status', [KycController::class, 'status']);
        Route::get('/requirements', [KycController::class, 'requirements']);
        Route::post('/submit', [KycController::class, 'submit']);
        Route::post('/documents', [KycController::class, 'upload']);
        Route::get('/documents/{documentId}/download', [KycController::class, 'downloadDocument']);
    });

    // GDPR endpoints
    Route::prefix('gdpr')->group(function () {
        Route::get('/consent', [GdprController::class, 'consentStatus']);
        Route::post('/consent', [GdprController::class, 'updateConsent']);
        Route::post('/export', [GdprController::class, 'requestDataExport']);
        Route::post('/delete', [GdprController::class, 'requestDeletion']);
        Route::get('/retention-policy', [GdprController::class, 'retentionPolicy']);
    });
});
