<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Property;

class StoreContractRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create-contract');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'property_id' => ['required', 'exists:properties,id', function ($attribute, $value, $fail) {
                $property = Property::find($value);
                if ($property && $property->status === 'rented') {
                    $fail('Ce bien est déjà loué.');
                }
            }],
            'tenant_id' => ['required', 'exists:users,id'],
            'agent_id' => ['nullable', 'exists:users,id'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'monthly_rent' => ['required', 'numeric', 'min:0'],
            'charges' => ['nullable', 'numeric', 'min:0'],
            'deposit_amount' => ['required', 'numeric', 'min:0'],
            'payment_day' => ['required', 'integer', 'between:1,28'],
            'terms_conditions' => ['required', 'string'],
            'special_clauses' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'property_id' => 'bien immobilier',
            'tenant_id' => 'locataire',
            'agent_id' => 'agent',
            'start_date' => 'date de début',
            'end_date' => 'date de fin',
            'monthly_rent' => 'loyer mensuel',
            'charges' => 'charges',
            'deposit_amount' => 'montant de la caution',
            'payment_day' => 'jour de paiement',
            'terms_conditions' => 'termes et conditions',
            'special_clauses' => 'clauses spéciales',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'end_date.after' => 'La date de fin doit être postérieure à la date de début.',
            'start_date.after_or_equal' => 'La date de début ne peut pas être dans le passé.',
            'payment_day.between' => 'Le jour de paiement doit être entre 1 et 28.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('property_id')) {
            $property = Property::find($this->property_id);
            
            if ($property && !$this->has('monthly_rent')) {
                $this->merge([
                    'monthly_rent' => $property->price_per_month,
                ]);
            }
            
            if ($property && !$this->has('charges')) {
                $this->merge([
                    'charges' => $property->charges,
                ]);
            }
            
            if ($property && !$this->has('deposit_amount')) {
                $this->merge([
                    'deposit_amount' => $property->deposit_amount,
                ]);
            }
        }
    }
}
