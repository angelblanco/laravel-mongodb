<?php

namespace AngelBlanco\Mongodb\Tests\models;

use AngelBlanco\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Photo extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'photos';
    protected static $unguarded = true;

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
