<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'contract_id',
        'user_id',
        'amount',
        'payment_date',
        'due_date',
        'payment_method',
        'status',
        'reference_number',
        'transaction_id',
        'late_fee',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'late_fee' => 'decimal:2',
        'payment_date' => 'date',
        'due_date' => 'date',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function scopeLate($query)
    {
        return $query->where('status', 'late')
                     ->orWhere(function($q) {
                         $q->where('status', 'pending')
                           ->where('due_date', '<', now());
                     });
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function getIsLateAttribute()
    {
        return $this->status === 'pending' && $this->due_date < now();
    }

    public function getDaysLateAttribute()
    {
        if (!$this->is_late) return 0;
        return now()->diffInDays($this->due_date);
    }

    public function getTotalAmountAttribute()
    {
        return $this->amount + $this->late_fee;
    }
}
