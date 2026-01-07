<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;

class Contract extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
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

    /**
     * Get the property for the contract.
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the tenant for the contract.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    /**
     * Get the agent for the contract.
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    /**
     * Get the payments for the contract.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the invoices for the contract.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Scope a query to only include active contracts.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include expiring contracts.
     */
    public function scopeExpiring($query, $days = 30)
    {
        return $query->where('status', 'active')
                     ->where('end_date', '<=', Carbon::now()->addDays($days))
                     ->where('end_date', '>=', Carbon::now());
    }

    /**
     * Scope a query to only include expired contracts.
     */
    public function scopeExpired($query)
    {
        return $query->where('status', 'active')
                     ->where('end_date', '<', Carbon::now());
    }

    /**
     * Check if the contract is active.
     */
    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if the contract is expiring soon.
     */
    public function getIsExpiringAttribute(): bool
    {
        if (!$this->is_active) {
            return false;
        }
        return $this->end_date->diffInDays(Carbon::now()) <= 30;
    }

    /**
     * Check if the contract is fully signed.
     */
    public function getIsFullySignedAttribute(): bool
    {
        return $this->signed_by_tenant && $this->signed_by_owner;
    }

    /**
     * Get the duration of the contract in months.
     */
    public function getDurationInMonthsAttribute(): int
    {
        return $this->start_date->diffInMonths($this->end_date);
    }

    /**
     * Get the total rent amount for the contract period.
     */
    public function getTotalRentAttribute(): float
    {
        return $this->monthly_rent * $this->duration_in_months;
    }

    /**
     * Get the monthly total (rent + charges).
     */
    public function getMonthlyTotalAttribute(): float
    {
        return $this->monthly_rent + $this->charges;
    }

    /**
     * Get the days remaining until end of contract.
     */
    public function getDaysRemainingAttribute(): int
    {
        if (!$this->is_active) {
            return 0;
        }
        return max(0, Carbon::now()->diffInDays($this->end_date, false));
    }

    /**
     * Check if the contract is owned by a specific user.
     */
    public function isOwnedBy(User $user): bool
    {
        return $this->property->owner_id === $user->id;
    }

    /**
     * Check if the contract is rented by a specific user.
     */
    public function isRentedBy(User $user): bool
    {
        return $this->tenant_id === $user->id;
    }

    /**
     * Generate a unique contract number.
     */
    public static function generateContractNumber(): string
    {
        $year = Carbon::now()->year;
        $lastContract = self::whereYear('created_at', $year)
                            ->orderBy('id', 'desc')
                            ->first();
        
        $number = $lastContract ? (int) substr($lastContract->contract_number, -4) + 1 : 1;
        
        return 'CTR-' . $year . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
