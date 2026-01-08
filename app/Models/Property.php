<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Property extends Model
{
    use SoftDeletes, LogsActivity;

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
        'deposit_months' => 'integer',
        'rooms' => 'integer',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
        'floor' => 'integer',
    ];

    // Configuration ActivityLog
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'title', 'description', 'price_per_month',
                'charges', 'status', 'type', 'address', 'city'
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('properties');
    }

    // Relations
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class)->orderBy('order');
    }

    public function primaryImage()
    {
        return $this->hasOne(PropertyImage::class)->where('is_primary', true);
    }

    public function documents()
    {
        return $this->hasMany(PropertyDocument::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function activeContract()
    {
        return $this->hasOne(Contract::class)->where('status', 'active');
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeRented($query)
    {
        return $query->where('status', 'rented');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Accessors
    public function getIsAvailableAttribute()
    {
        return $this->status === 'available';
    }

    public function getTotalPriceAttribute()
    {
        return $this->price_per_month + $this->charges;
    }
}