<?php

namespace AngelBlanco\Mongodb\Tests\models;

use AngelBlanco\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'groups';
    protected static $unguarded = true;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'users',
            'groups',
            'users',
            '_id',
            '_id',
            'users'
        );
    }
}
