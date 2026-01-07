<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Property extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'owner_id',
        'title',
        'description',
        'address',
        'city',
        'postal_code',
        'country',
        'latitude',
        'longitude',
        'type',
        'surface_area',
        'rooms',
        'bedrooms',
        'bathrooms',
        'floor',
        'has_parking',
        'has_elevator',
        'has_balcony',
        'has_garden',
        'price_per_month',
        'charges',
        'deposit_months',
        'status',
        'available_from',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'has_parking' => 'boolean',
        'has_elevator' => 'boolean',
        'has_balcony' => 'boolean',
        'has_garden' => 'boolean',
        'price_per_month' => 'decimal:2',
        'charges' => 'decimal:2',
        'surface_area' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'available_from' => 'date',
    ];

    /**
     * Get the owner of the property.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the images for the property.
     */
    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class)->orderBy('order');
    }

    /**
     * Get the primary image for the property.
     */
    public function primaryImage(): HasOne
    {
        return $this->hasOne(PropertyImage::class)->where('is_primary', true);
    }

    /**
     * Get the documents for the property.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(PropertyDocument::class);
    }

    /**
     * Get the contracts for the property.
     */
    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    /**
     * Get the active contract for the property.
     */
    public function activeContract(): HasOne
    {
        return $this->hasOne(Contract::class)->where('status', 'active');
    }

    /**
     * Get the maintenance requests for the property.
     */
    public function maintenanceRequests(): HasMany
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    /**
     * Scope a query to only include available properties.
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope a query to only include rented properties.
     */
    public function scopeRented($query)
    {
        return $query->where('status', 'rented');
    }

    /**
     * Scope a query to filter by type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to filter by city.
     */
    public function scopeByCity($query, $city)
    {
        return $query->where('city', $city);
    }

    /**
     * Scope a query to filter by price range.
     */
    public function scopeByPriceRange($query, $min, $max)
    {
        return $query->whereBetween('price_per_month', [$min, $max]);
    }

    /**
     * Check if the property is available.
     */
    public function getIsAvailableAttribute(): bool
    {
        return $this->status === 'available';
    }

    /**
     * Get the total price (rent + charges).
     */
    public function getTotalPriceAttribute(): float
    {
        return $this->price_per_month + $this->charges;
    }

    /**
     * Get the deposit amount.
     */
    public function getDepositAmountAttribute(): float
    {
        return $this->price_per_month * $this->deposit_months;
    }

    /**
     * Check if the property is owned by a specific user.
     */
    public function isOwnedBy(User $user): bool
    {
        return $this->owner_id === $user->id;
    }
}
