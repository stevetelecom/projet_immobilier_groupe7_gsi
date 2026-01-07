<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class MaintenanceRequest extends Model
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'cost_estimate' => 'decimal:2',
        'actual_cost' => 'decimal:2',
        'scheduled_date' => 'datetime',
        'completed_at' => 'datetime',
        'rating' => 'integer',
    ];

    /**
     * Get the property for the maintenance request.
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the tenant for the maintenance request.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    /**
     * Get the assigned user for the maintenance request.
     */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the images for the maintenance request.
     */
    public function images(): HasMany
    {
        return $this->hasMany(MaintenanceImage::class);
    }

    /**
     * Scope a query to only include pending requests.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include in progress requests.
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Scope a query to only include completed requests.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include urgent requests.
     */
    public function scopeUrgent($query)
    {
        return $query->where('priority', 'urgent');
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Check if the request is completed.
     */
    public function getIsCompletedAttribute(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if the request is urgent.
     */
    public function getIsUrgentAttribute(): bool
    {
        return $this->priority === 'urgent';
    }

    /**
     * Get the response time in hours.
     */
    public function getResponseTimeAttribute(): ?int
    {
        if (!$this->scheduled_date) {
            return null;
        }
        return $this->created_at->diffInHours($this->scheduled_date);
    }

    /**
     * Get the resolution time in hours.
     */
    public function getResolutionTimeAttribute(): ?int
    {
        if (!$this->completed_at) {
            return null;
        }
        return $this->created_at->diffInHours($this->completed_at);
    }

    /**
     * Get the priority color for UI display.
     */
    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'urgent' => 'red',
            'high' => 'orange',
            'normal' => 'yellow',
            'low' => 'green',
            default => 'gray',
        };
    }

    /**
     * Get the status color for UI display.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'assigned' => 'blue',
            'in_progress' => 'indigo',
            'completed' => 'green',
            'cancelled' => 'red',
            default => 'gray',
        };
    }
}
