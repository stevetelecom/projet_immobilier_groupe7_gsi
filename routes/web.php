<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicPropertyController;
use App\Http\Controllers\ContactController;
use Inertia\Inertia;


// ===== ROUTES PUBLIQUES (COMMENCEZ ICI) =====

// Page d'accueil
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'featuredProperties' => \App\Models\Property::where('status', 'available')
            ->latest()
            ->limit(6)
            ->get(),
        'propertiesCount' => [
            'appartement' => \App\Models\Property::where('type', 'appartement')->where('status', 'available')->count(),
            'maison' => \App\Models\Property::where('type', 'maison')->where('status', 'available')->count(),
            'bureau' => \App\Models\Property::where('type', 'bureau')->where('status', 'available')->count(),
            'commerce' => \App\Models\Property::where('type', 'commerce')->where('status', 'available')->count(),
            'terrain' => \App\Models\Property::where('type', 'terrain')->where('status', 'available')->count(),
        ],
    ]);
})->name('home');

// Biens disponibles
Route::get('/biens', [PublicPropertyController::class, 'index'])->name('public.properties.index');
Route::get('/biens/{property}', [PublicPropertyController::class, 'show'])->name('public.properties.show');

// À propos
Route::get('/a-propos', function () {
    return Inertia::render('APropos');
})->name('about');

// Contact
Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('contact.show');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// ===== FIN DES ROUTES PUBLIQUES =====
/*
|--------------------------------------------------------------------------
| Routes Web
|--------------------------------------------------------------------------
|
| Application de Gestion de Contrats de Location de Biens Immobiliers
| Groupe 7 - GSI
|
*/

// Page d'accueil publique
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

/*
|--------------------------------------------------------------------------
| Routes Authentifiées
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    
    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Profil Utilisateur
    |--------------------------------------------------------------------------
    */
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        
        // Mise à jour spécifique du mot de passe
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
        
        // Upload de photo de profil
        Route::post('/photo', [ProfileController::class, 'updatePhoto'])->name('photo.update');
        Route::delete('/photo', [ProfileController::class, 'deletePhoto'])->name('photo.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Gestion des Utilisateurs (Admin uniquement)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:administrateur'])->group(function () {
        Route::resource('users', UserController::class);
        
        // Routes supplémentaires pour les utilisateurs
        Route::post('users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
        Route::delete('users/{user}/force-delete', [UserController::class, 'forceDelete'])->name('users.force-delete');
        Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    });

    /*
    |--------------------------------------------------------------------------
    | Gestion des Biens Immobiliers
    |--------------------------------------------------------------------------
    */
    Route::resource('properties', PropertyController::class);
    
    // Routes supplémentaires pour les biens
    Route::prefix('properties')->name('properties.')->group(function () {
        // Galerie de photos
        Route::post('{property}/photos', [PropertyController::class, 'uploadPhotos'])->name('photos.upload');
        Route::delete('{property}/photos/{photo}', [PropertyController::class, 'deletePhoto'])->name('photos.delete');
        Route::patch('{property}/photos/{photo}/primary', [PropertyController::class, 'setPrimaryPhoto'])->name('photos.primary');
        
        // Documents liés au bien
        Route::post('{property}/documents', [PropertyController::class, 'uploadDocument'])->name('documents.upload');
        Route::delete('{property}/documents/{document}', [PropertyController::class, 'deleteDocument'])->name('documents.delete');
        Route::get('{property}/documents/{document}/download', [PropertyController::class, 'downloadDocument'])->name('documents.download');
        
        // Disponibilité et historique
        Route::patch('{property}/availability', [PropertyController::class, 'updateAvailability'])->name('availability.update');
        Route::get('{property}/history', [PropertyController::class, 'history'])->name('history');
        
        // Statistiques du bien
        Route::get('{property}/stats', [PropertyController::class, 'stats'])->name('stats');
    });

    /*
    |--------------------------------------------------------------------------
    | Gestion des Contrats de Location
    |--------------------------------------------------------------------------
    */
    Route::resource('contracts', ContractController::class);
    
    // Routes supplémentaires pour les contrats
    Route::prefix('contracts')->name('contracts.')->group(function () {
        // Signature électronique
        Route::post('{contract}/sign', [ContractController::class, 'sign'])->name('sign');
        Route::get('{contract}/preview', [ContractController::class, 'preview'])->name('preview');
        Route::get('{contract}/download', [ContractController::class, 'download'])->name('download');
        
        // Renouvellement et résiliation
        Route::post('{contract}/renew', [ContractController::class, 'renew'])->name('renew');
        Route::post('{contract}/terminate', [ContractController::class, 'terminate'])->name('terminate');
        
        // Timeline et historique
        Route::get('{contract}/timeline', [ContractController::class, 'timeline'])->name('timeline');
        
        // Révision de loyer
        Route::post('{contract}/rent-revision', [ContractController::class, 'rentRevision'])->name('rent-revision');
        
        // Envoi par email
        Route::post('{contract}/send-email', [ContractController::class, 'sendEmail'])->name('send-email');
    });

    /*
    |--------------------------------------------------------------------------
    | Gestion des Paiements
    |--------------------------------------------------------------------------
    */
    Route::resource('payments', PaymentController::class)->except(['create', 'edit']);
    
    // Routes supplémentaires pour les paiements
    Route::prefix('payments')->name('payments.')->group(function () {
        // Enregistrer un paiement
        Route::post('contract/{contract}', [PaymentController::class, 'storeForContract'])->name('store-for-contract');
        
        // Paiements en retard
        Route::get('late', [PaymentController::class, 'late'])->name('late');
        
        // Historique des paiements
        Route::get('contract/{contract}/history', [PaymentController::class, 'contractHistory'])->name('contract-history');
        
        // Statistiques
        Route::get('stats', [PaymentController::class, 'stats'])->name('stats');
        
        // Rappels de paiement
        Route::post('{payment}/send-reminder', [PaymentController::class, 'sendReminder'])->name('send-reminder');
    });

    /*
    |--------------------------------------------------------------------------
    | Gestion des Quittances et Factures
    |--------------------------------------------------------------------------
    */
    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('index');
        Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('show');
        Route::get('/{invoice}/download', [InvoiceController::class, 'download'])->name('download');
        Route::post('/{invoice}/send-email', [InvoiceController::class, 'sendEmail'])->name('send-email');
        
        // Génération automatique de quittances
        Route::post('/generate-monthly', [InvoiceController::class, 'generateMonthly'])->name('generate-monthly');
        Route::post('/contract/{contract}/generate', [InvoiceController::class, 'generateForContract'])->name('generate-for-contract');
        
        // Quittances par contrat
        Route::get('/contract/{contract}', [InvoiceController::class, 'byContract'])->name('by-contract');
    });

    /*
    |--------------------------------------------------------------------------
    | Gestion des Réclamations et Maintenance
    |--------------------------------------------------------------------------
    */
    Route::resource('maintenance', MaintenanceController::class);
    
    // Routes supplémentaires pour la maintenance
    Route::prefix('maintenance')->name('maintenance.')->group(function () {
        // Upload d'images pour les réclamations
        Route::post('{maintenance}/images', [MaintenanceController::class, 'uploadImages'])->name('images.upload');
        Route::delete('{maintenance}/images/{image}', [MaintenanceController::class, 'deleteImage'])->name('images.delete');
        
        // Changement de statut
        Route::patch('{maintenance}/status', [MaintenanceController::class, 'updateStatus'])->name('status.update');
        Route::patch('{maintenance}/priority', [MaintenanceController::class, 'updatePriority'])->name('priority.update');
        
        // Affectation d'un technicien/agent
        Route::post('{maintenance}/assign', [MaintenanceController::class, 'assign'])->name('assign');
        
        // Commentaires et suivi
        Route::post('{maintenance}/comments', [MaintenanceController::class, 'addComment'])->name('comments.add');
        
        // Réclamations par propriété
        Route::get('property/{property}', [MaintenanceController::class, 'byProperty'])->name('by-property');
        
        // Réclamations par statut
        Route::get('status/{status}', [MaintenanceController::class, 'byStatus'])->name('by-status');
        
        // Statistiques
        Route::get('stats', [MaintenanceController::class, 'stats'])->name('stats');
    });

    /*
    |--------------------------------------------------------------------------
    | Rapports et Statistiques
    |--------------------------------------------------------------------------
    */
    Route::prefix('reports')->name('reports.')->group(function () {
        // Vue d'ensemble
        Route::get('/', [ReportController::class, 'overview'])->name('overview');
        
        // Rapports par catégorie
        Route::get('/properties', [ReportController::class, 'properties'])->name('properties');
        Route::get('/payments', [ReportController::class, 'payments'])->name('payments');
        Route::get('/maintenance', [ReportController::class, 'maintenance'])->name('maintenance');
        Route::get('/financial', [ReportController::class, 'financial'])->name('financial');
        
        // Export des rapports
        Route::post('/export/pdf', [ReportController::class, 'exportPdf'])->name('export.pdf');
        Route::post('/export/excel', [ReportController::class, 'exportExcel'])->name('export.excel');
        Route::post('/export/csv', [ReportController::class, 'exportCsv'])->name('export.csv');
        
        // Rapports personnalisés
        Route::post('/custom', [ReportController::class, 'custom'])->name('custom');
        
        // Rapports par période
        Route::get('/period/{period}', [ReportController::class, 'byPeriod'])->name('by-period');
    });

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/unread', [NotificationController::class, 'unread'])->name('unread');
        Route::post('/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('mark-as-read');
        Route::post('/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-as-read');
        Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('destroy');
        Route::delete('/', [NotificationController::class, 'destroyAll'])->name('destroy-all');
    });
});

/*
|--------------------------------------------------------------------------
| Routes d'Authentification
|--------------------------------------------------------------------------
*/
// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::resource('properties', PublicPropertyController::class);
// });

require __DIR__.'/auth.php';