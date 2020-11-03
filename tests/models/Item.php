<?php

namespace AngelBlanco\Mongodb\Tests\models;

use AngelBlanco\Mongodb\Eloquent\Builder;
use AngelBlanco\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Item.
 *
 * @property \Carbon\Carbon $created_at
 */
class Item extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'items';
    protected static $unguarded = true;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSharp(Builder $query)
    {
        return $query->where('type', 'sharp');
    }
}
