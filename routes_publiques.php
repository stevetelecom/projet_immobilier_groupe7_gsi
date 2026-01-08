<?php

/*
|--------------------------------------------------------------------------
| Routes Publiques - À ajouter dans routes/web.php
|--------------------------------------------------------------------------
|
| Ces routes permettent aux visiteurs de voir les biens disponibles
| sans avoir besoin de s'inscrire.
|
| IMPORTANT: Placez ces routes AVANT la route '/' existante dans web.php
|
*/

use App\Http\Controllers\PublicPropertyController;
use App\Http\Controllers\ContactController;
use Inertia\Inertia;

// Page d'accueil publique avec biens en vedette
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'featuredProperties' => \App\Models\Property::where('status', 'available')
            ->with('owner')
            ->latest()
            ->limit(6)
            ->get()
            ->map(function ($property) {
                return [
                    'id' => $property->id,
                    'title' => $property->title,
                    'type' => $property->type,
                    'address' => $property->address,
                    'city' => $property->city,
                    'surface' => $property->surface,
                    'rooms' => $property->rooms,
                    'bedrooms' => $property->bedrooms,
                    'rent_amount' => $property->rent_amount,
                    'primary_photo' => $property->primary_photo_url ?? null,
                ];
            }),
        'propertiesCount' => [
            'appartement' => \App\Models\Property::where('type', 'appartement')->where('status', 'available')->count(),
            'maison' => \App\Models\Property::where('type', 'maison')->where('status', 'available')->count(),
            'bureau' => \App\Models\Property::where('type', 'bureau')->where('status', 'available')->count(),
            'commerce' => \App\Models\Property::where('type', 'commerce')->where('status', 'available')->count(),
            'terrain' => \App\Models\Property::where('type', 'terrain')->where('status', 'available')->count(),
        ],
    ]);
})->name('home');

// Liste publique des biens disponibles avec filtres
Route::get('/biens', [PublicPropertyController::class, 'index'])->name('public.properties.index');

// Détails d'un bien (accessible sans authentification)
Route::get('/biens/{property}', [PublicPropertyController::class, 'show'])->name('public.properties.show');

// Page À propos
Route::get('/a-propos', function () {
    return Inertia::render('APropos');
})->name('about');

// Page Contact
Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('contact.show');

// Formulaire de contact (POST)
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
