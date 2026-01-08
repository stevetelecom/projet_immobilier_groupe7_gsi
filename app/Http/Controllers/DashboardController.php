<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Property;
use App\Models\Contract;
use App\Models\Payment;
use App\Models\MaintenanceRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Statistiques selon le rôle
        if ($user->hasRole('administrateur')) {
            $stats = [
                'total_properties' => Property::count(),
                'active_contracts' => Contract::where('status', 'active')->count(),
                'monthly_revenue' => Payment::where('status', 'paid')
                    ->whereMonth('payment_date', now()->month)
                    ->sum('amount'),
                'pending_maintenance' => MaintenanceRequest::where('status', 'pending')->count(),
            ];
        } elseif ($user->hasRole('proprietaire')) {
            $stats = [
                'total_properties' => $user->ownedProperties()->count(),
                'active_contracts' => Contract::whereHas('property', function($q) use ($user) {
                    $q->where('owner_id', $user->id);
                })->where('status', 'active')->count(),
                'monthly_revenue' => Payment::whereHas('contract.property', function($q) use ($user) {
                    $q->where('owner_id', $user->id);
                })->where('status', 'paid')
                  ->whereMonth('payment_date', now()->month)
                  ->sum('amount'),
                'pending_maintenance' => MaintenanceRequest::whereHas('property', function($q) use ($user) {
                    $q->where('owner_id', $user->id);
                })->where('status', 'pending')->count(),
            ];
        } else { // locataire
            $stats = [
                'total_properties' => 1,
                'active_contracts' => $user->contracts()->where('status', 'active')->count(),
                'monthly_revenue' => 0,
                'pending_maintenance' => $user->maintenanceRequests()->where('status', 'pending')->count(),
            ];
        }

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'revenueData' => [], // À compléter plus tard avec des données réelles
            'propertyStatus' => [
                'available' => Property::where('status', 'available')->count(),
                'rented' => Property::where('status', 'rented')->count(),
                'maintenance' => Property::where('status', 'maintenance')->count(),
            ],
            'recentActivities' => [], // À compléter plus tard
        ]);
    }
}