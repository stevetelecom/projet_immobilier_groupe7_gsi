<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $property = $this->route('property');
        
        // Admin peut tout modifier
        if ($this->user()->can('update-property') && $this->user()->is_admin) {
            return true;
        }
        
        // Le propriétaire peut modifier ses propres biens
        return $this->user()->can('update-property') && 
               $property->isOwnedBy($this->user());
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'address' => ['sometimes', 'string', 'max:255'],
            'city' => ['sometimes', 'string', 'max:100'],
            'postal_code' => ['sometimes', 'string', 'max:10'],
            'country' => ['sometimes', 'string', 'max:100'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'type' => ['sometimes', 'in:apartment,house,office,studio,villa,commercial'],
            'surface_area' => ['sometimes', 'numeric', 'min:0'],
            'rooms' => ['sometimes', 'integer', 'min:1'],
            'bedrooms' => ['sometimes', 'integer', 'min:0'],
            'bathrooms' => ['sometimes', 'integer', 'min:0'],
            'floor' => ['nullable', 'integer'],
            'has_parking' => ['boolean'],
            'has_elevator' => ['boolean'],
            'has_balcony' => ['boolean'],
            'has_garden' => ['boolean'],
            'price_per_month' => ['sometimes', 'numeric', 'min:0'],
            'charges' => ['nullable', 'numeric', 'min:0'],
            'deposit_months' => ['sometimes', 'integer', 'min:1', 'max:12'],
            'status' => ['sometimes', 'in:available,rented,maintenance,unavailable'],
            'available_from' => ['nullable', 'date'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'title' => 'titre',
            'description' => 'description',
            'address' => 'adresse',
            'city' => 'ville',
            'postal_code' => 'code postal',
            'country' => 'pays',
            'type' => 'type de bien',
            'surface_area' => 'superficie',
            'rooms' => 'nombre de pièces',
            'bedrooms' => 'nombre de chambres',
            'bathrooms' => 'nombre de salles de bain',
            'floor' => 'étage',
            'price_per_month' => 'loyer mensuel',
            'charges' => 'charges',
            'deposit_months' => 'mois de caution',
            'status' => 'statut',
            'available_from' => 'disponible à partir du',
        ];
    }
}
