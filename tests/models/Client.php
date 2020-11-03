<?php

namespace AngelBlanco\Mongodb\Tests\models;

use AngelBlanco\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Client extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'clients';
    protected static $unguarded = true;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function photo(): MorphOne
    {
        return $this->morphOne(Photo::class, 'imageable');
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(
            Address::class,
            'data.client_id',
            'data.client_id'
        );
    }
}
