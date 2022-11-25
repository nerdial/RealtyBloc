<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_address',
        'address',
        'price',
        'image_address',
        'type',
        'entity_id',
        'engine_id',
        'metadata',
        'description'
    ];

    protected $casts = [
        'metadata' => 'array'
    ];

    public function metadata(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PropertyMetadata::class);
    }
}
