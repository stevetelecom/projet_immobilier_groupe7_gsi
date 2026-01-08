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
        $query = Property::query()
            ->where('status', 'available')
            ->with('owner');

        // Recherche par texte
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtrer par type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filtrer par prix maximum
        if ($request->filled('max_price')) {
            $query->where('rent_amount', '<=', $request->max_price);
        }

        // Filtrer par surface minimum
        if ($request->filled('min_surface')) {
            $query->where('surface', '>=', $request->min_surface);
        }

        // Filtrer par nombre de chambres minimum
        if ($request->filled('min_bedrooms')) {
            $query->where('bedrooms', '>=', $request->min_bedrooms);
        }

        // Tri
        $sort = $request->get('sort', 'recent');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('rent_amount', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('rent_amount', 'desc');
                break;
            case 'surface_desc':
                $query->orderBy('surface', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $properties = $query->paginate(12)->withQueryString();

        // Transformer les données pour le frontend
        $properties->getCollection()->transform(function ($property) {
            return [
                'id' => $property->id,
                'title' => $property->title,
                'type' => $property->type,
                'address' => $property->address,
                'city' => $property->city,
                'surface' => $property->surface,
                'rooms' => $property->rooms,
                'bedrooms' => $property->bedrooms,
                'bathrooms' => $property->bathrooms,
                'rent_amount' => $property->rent_amount,
                'primary_photo' => $property->primary_photo_url ?? null,
            ];
        });

        return Inertia::render('Biens', [
            'properties' => $properties,
            'filters' => $request->only(['search', 'type', 'max_price', 'min_surface', 'min_bedrooms', 'sort']),
        ]);
    }

    /**
     * Afficher les détails d'un bien (page publique)
     */
    public function show(Property $property)
    {
        // Charger les relations nécessaires
        $property->load(['owner', 'photos', 'documents']);

        return Inertia::render('BienDetails', [
            'property' => [
                'id' => $property->id,
                'title' => $property->title,
                'description' => $property->description,
                'type' => $property->type,
                'address' => $property->address,
                'city' => $property->city,
                'postal_code' => $property->postal_code,
                'surface' => $property->surface,
                'rooms' => $property->rooms,
                'bedrooms' => $property->bedrooms,
                'bathrooms' => $property->bathrooms,
                'rent_amount' => $property->rent_amount,
                'deposit_amount' => $property->deposit_amount,
                'status' => $property->status,
                'photos' => $property->photos->map(function ($photo) {
                    return [
                        'id' => $photo->id,
                        'url' => $photo->url,
                        'is_primary' => $photo->is_primary,
                    ];
                }),
                'owner' => [
                    'name' => $property->owner->name,
                    'phone' => $property->owner->phone ?? null,
                    'email' => $property->owner->email,
                ],
                'created_at' => $property->created_at->format('d/m/Y'),
            ],
            'similarProperties' => Property::where('type', $property->type)
                ->where('id', '!=', $property->id)
                ->where('status', 'available')
                ->limit(3)
                ->get()
                ->map(function ($prop) {
                    return [
                        'id' => $prop->id,
                        'title' => $prop->title,
                        'type' => $prop->type,
                        'city' => $prop->city,
                        'rent_amount' => $prop->rent_amount,
                        'primary_photo' => $prop->primary_photo_url ?? null,
                    ];
                }),
        ]);
    }
}
