<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'contract_id',
        'user_id',
        'amount',
        'late_fee',
        'payment_date',
        'due_date',
        'payment_method',
        'status',
        'reference_number',
        'transaction_id',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'late_fee' => 'decimal:2',
        'payment_date' => 'date',
        'due_date' => 'date',
    ];

    /**
     * Get the contract for the payment.
     */
    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    /**
     * Get the user for the payment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the invoice for the payment.
     */
    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    /**
     * Scope a query to only include late payments.
     */
    public function scopeLate($query)
    {
        return $query->where('status', 'late')
                     ->orWhere(function($q) {
                         $q->where('status', 'pending')
                           ->where('due_date', '<', Carbon::now());
                     });
    }

    /**
     * Scope a query to only include pending payments.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include paid payments.
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope a query to only include payments due in a specific month.
     */
    public function scopeDueInMonth($query, $month, $year)
    {
        return $query->whereMonth('due_date', $month)
                     ->whereYear('due_date', $year);
    }

    /**
     * Check if the payment is late.
     */
    public function getIsLateAttribute(): bool
    {
        return $this->status === 'pending' && $this->due_date < Carbon::now()->startOfDay();
    }

    /**
     * Get the number of days the payment is late.
     */
    public function getDaysLateAttribute(): int
    {
        if (!$this->is_late) {
            return 0;
        }
        return Carbon::now()->startOfDay()->diffInDays($this->due_date);
    }

    /**
     * Get the total amount including late fees.
     */
    public function getTotalAmountAttribute(): float
    {
        return $this->amount + $this->late_fee;
    }

    /**
     * Check if the payment is paid.
     */
    public function getIsPaidAttribute(): bool
    {
        return $this->status === 'paid';
    }

    /**
     * Calculate late fee based on days late.
     */
    public function calculateLateFee(): float
    {
        if (!$this->is_late) {
            return 0;
        }
        
        // 2% de pénalité par semaine de retard (configurable)
        $daysLate = $this->days_late;
        $weeksLate = ceil($daysLate / 7);
        $penaltyRate = 0.02; // 2%
        
        return round($this->amount * $penaltyRate * $weeksLate, 2);
    }

    /**
     * Generate a unique reference number.
     */
    public static function generateReferenceNumber(): string
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->format('m');
        $random = strtoupper(substr(md5(uniqid()), 0, 6));
        
        return 'PAY-' . $year . $month . '-' . $random;
    }
}
