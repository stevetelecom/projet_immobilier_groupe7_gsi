<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Contract extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'property_id',
        'tenant_id',
        'agent_id',
        'contract_number',
        'start_date',
        'end_date',
        'monthly_rent',
        'charges',
        'deposit_amount',
        'payment_day',
        'terms_conditions',
        'special_clauses',
        'signature_date',
        'signed_by_tenant',
        'tenant_signature',
        'signed_by_owner',
        'owner_signature',
        'status',
        'pdf_path',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'monthly_rent' => 'decimal:2',
        'charges' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'payment_day' => 'integer',
        'signed_by_tenant' => 'boolean',
        'signed_by_owner' => 'boolean',
        'signature_date' => 'datetime',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeExpiring($query, $days = 30)
    {
        return $query->where('status', 'active')
                     ->where('end_date', '<=', Carbon::now()->addDays($days));
    }

    public function getIsActiveAttribute()
    {
        return $this->status === 'active';
    }

    public function getIsExpiringAttribute()
    {
        return $this->end_date->diffInDays(Carbon::now()) <= 30;
    }

    public function getIsFullySignedAttribute()
    {
        return $this->signed_by_tenant && $this->signed_by_owner;
    }

    public function getDurationInMonthsAttribute()
    {
        return $this->start_date->diffInMonths($this->end_date);
    }
}