<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicPropertyController extends Controller
{
    /**
     * Afficher la liste des biens disponibles (page publique)
     */
    public function index(Request $request)
    {
        $query = Property::with(['owner', 'primaryImage'])
            ->where('status', 'available');

        // Filtres
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('min_price')) {
            $query->where('price_per_month', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price_per_month', '<=', $request->max_price);
        }

        if ($request->filled('rooms')) {
            $query->where('rooms', '>=', $request->rooms);
        }

        // Tri
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $properties = $query->paginate(12)->withQueryString();

        // Types de biens pour les filtres
        $propertyTypes = [
            'apartment' => 'Appartement',
            'house' => 'Maison',
            'studio' => 'Studio',
            'villa' => 'Villa',
            'office' => 'Bureau',
            'commercial' => 'Commercial'
        ];

        return Inertia::render('Properties/PublicIndex', [
            'properties' => $properties,
            'propertyTypes' => $propertyTypes,
            'filters' => $request->only(['type', 'city', 'min_price', 'max_price', 'rooms', 'sort', 'order'])
        ]);
    }

    /**
     * Afficher les détails d'un bien (page publique)
     */
    public function show(Property $property)
    {
        // Charger les relations nécessaires
        $property->load([
            'owner',
            'images' => function ($query) {
                $query->orderBy('order');
            }
        ]);

        // Biens similaires
        $similarProperties = Property::where('status', 'available')
            ->where('id', '!=', $property->id)
            ->where('type', $property->type)
            ->where('city', $property->city)
            ->with(['primaryImage'])
            ->limit(4)
            ->get();

        return Inertia::render('Properties/PublicShow', [
            'property' => $property,
            'similarProperties' => $similarProperties
        ]);
    }
}