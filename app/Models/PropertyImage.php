<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyImage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'property_id',
        'image_path',
        'is_primary',
        'order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'order' => 'integer',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
