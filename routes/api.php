<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\ContractController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\MaintenanceController;
use App\Http\Controllers\Api\NotificationController;

/*
|--------------------------------------------------------------------------
| Routes API
|--------------------------------------------------------------------------
|
| Routes API pour l'application mobile ou intégrations tierces
| Toutes les routes sont protégées par Sanctum
|
*/

Route::middleware('auth:sanctum')->group(function () {
    
    // Informations utilisateur
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    /*
    |--------------------------------------------------------------------------
    | Biens Immobiliers API
    |--------------------------------------------------------------------------
    */
    Route::prefix('properties')->name('api.properties.')->group(function () {
        Route::get('/', [PropertyController::class, 'index']);
        Route::get('/{property}', [PropertyController::class, 'show']);
        Route::get('/search', [PropertyController::class, 'search']);
        Route::get('/available', [PropertyController::class, 'available']);
    });

    /*
    |--------------------------------------------------------------------------
    | Contrats API
    |--------------------------------------------------------------------------
    */
    Route::prefix('contracts')->name('api.contracts.')->group(function () {
        Route::get('/', [ContractController::class, 'index']);
        Route::get('/{contract}', [ContractController::class, 'show']);
        Route::get('/user/{user}', [ContractController::class, 'byUser']);
        Route::get('/property/{property}', [ContractController::class, 'byProperty']);
    });

    /*
    |--------------------------------------------------------------------------
    | Paiements API
    |--------------------------------------------------------------------------
    */
    Route::prefix('payments')->name('api.payments.')->group(function () {
        Route::get('/', [PaymentController::class, 'index']);
        Route::get('/{payment}', [PaymentController::class, 'show']);
        Route::get('/contract/{contract}', [PaymentController::class, 'byContract']);
        Route::get('/late', [PaymentController::class, 'late']);
        Route::post('/', [PaymentController::class, 'store']);
    });

    /*
    |--------------------------------------------------------------------------
    | Maintenance API
    |--------------------------------------------------------------------------
    */
    Route::prefix('maintenance')->name('api.maintenance.')->group(function () {
        Route::get('/', [MaintenanceController::class, 'index']);
        Route::get('/{maintenance}', [MaintenanceController::class, 'show']);
        Route::post('/', [MaintenanceController::class, 'store']);
        Route::patch('/{maintenance}/status', [MaintenanceController::class, 'updateStatus']);
        Route::get('/property/{property}', [MaintenanceController::class, 'byProperty']);
    });

    /*
    |--------------------------------------------------------------------------
    | Notifications API
    |--------------------------------------------------------------------------
    */
    Route::prefix('notifications')->name('api.notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index']);
        Route::get('/unread', [NotificationController::class, 'unread']);
        Route::post('/{notification}/read', [NotificationController::class, 'markAsRead']);
        Route::post('/read-all', [NotificationController::class, 'markAllAsRead']);
    });

    /*
    |--------------------------------------------------------------------------
    | Dashboard & Stats API
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard/stats', function (Request $request) {
        return response()->json([
            'properties_count' => \App\Models\Property::count(),
            'contracts_active' => \App\Models\Contract::where('status', 'active')->count(),
            'payments_pending' => \App\Models\Payment::where('status', 'pending')->count(),
            'maintenance_open' => \App\Models\Maintenance::whereIn('status', ['pending', 'in_progress'])->count(),
        ]);
    });
});

/*
|--------------------------------------------------------------------------
| Webhooks (non authentifiées)
|--------------------------------------------------------------------------
*/
Route::post('/webhooks/payment', function (Request $request) {
    // Traiter les webhooks de paiement (ex: Stripe, PayPal)
    // Vérifier la signature du webhook
    // Mettre à jour le statut du paiement
});