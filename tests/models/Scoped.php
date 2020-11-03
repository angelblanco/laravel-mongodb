<?php

namespace AngelBlanco\Mongodb\Tests\models;

use AngelBlanco\Mongodb\Eloquent\Builder;
use AngelBlanco\Mongodb\Eloquent\Model as Eloquent;

class Scoped extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'scoped';
    protected $fillable = ['name', 'favorite'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('favorite', function (Builder $builder) {
            $builder->where('favorite', true);
        });
    }
}
