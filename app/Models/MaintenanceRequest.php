<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaintenanceRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'property_id',
        'tenant_id',
        'assigned_to',
        'title',
        'description',
        'priority',
        'category',
        'status',
        'cost_estimate',
        'actual_cost',
        'scheduled_date',
        'completed_at',
        'rating',
        'feedback',
    ];

    protected $casts = [
        'cost_estimate' => 'decimal:2',
        'actual_cost' => 'decimal:2',
        'scheduled_date' => 'datetime',
        'completed_at' => 'datetime',
        'rating' => 'integer',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function images()
    {
        return $this->hasMany(MaintenanceImage::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeUrgent($query)
    {
        return $query->where('priority', 'urgent');
    }

    public function getIsCompletedAttribute()
    {
        return $this->status === 'completed';
    }

    public function getResponseTimeAttribute()
    {
        if (!$this->scheduled_date) return null;
        return $this->created_at->diffInHours($this->scheduled_date);
    }
}