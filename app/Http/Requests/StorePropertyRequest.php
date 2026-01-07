<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create-property');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'postal_code' => ['required', 'string', 'max:10'],
            'country' => ['required', 'string', 'max:100'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'type' => ['required', 'in:apartment,house,office,studio,villa,commercial'],
            'surface_area' => ['required', 'numeric', 'min:0'],
            'rooms' => ['required', 'integer', 'min:1'],
            'bedrooms' => ['required', 'integer', 'min:0'],
            'bathrooms' => ['required', 'integer', 'min:0'],
            'floor' => ['nullable', 'integer'],
            'has_parking' => ['boolean'],
            'has_elevator' => ['boolean'],
            'has_balcony' => ['boolean'],
            'has_garden' => ['boolean'],
            'price_per_month' => ['required', 'numeric', 'min:0'],
            'charges' => ['nullable', 'numeric', 'min:0'],
            'deposit_months' => ['required', 'integer', 'min:1', 'max:12'],
            'status' => ['required', 'in:available,rented,maintenance,unavailable'],
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

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'type.in' => 'Le type de bien doit être: appartement, maison, bureau, studio, villa ou commercial.',
            'status.in' => 'Le statut doit être: disponible, loué, maintenance ou indisponible.',
        ];
    }
}
