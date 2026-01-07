<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaintenanceRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create-maintenance');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'property_id' => ['required', 'exists:properties,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'priority' => ['required', 'in:low,normal,high,urgent'],
            'category' => ['required', 'in:plumbing,electrical,heating,security,cleaning,other'],
            'images' => ['nullable', 'array', 'max:5'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'property_id' => 'bien immobilier',
            'title' => 'titre',
            'description' => 'description',
            'priority' => 'priorité',
            'category' => 'catégorie',
            'images' => 'images',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'priority.in' => 'La priorité doit être: faible, normale, élevée ou urgente.',
            'category.in' => 'La catégorie doit être: plomberie, électricité, chauffage, sécurité, nettoyage ou autre.',
            'images.max' => 'Vous ne pouvez télécharger que 5 images maximum.',
            'images.*.max' => 'Chaque image ne doit pas dépasser 2 Mo.',
        ];
    }
}
