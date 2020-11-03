<?php

namespace AngelBlanco\Mongodb\Tests\models;

use AngelBlanco\Mongodb\Eloquent\SoftDeletes;
use AngelBlanco\Mongodb\Eloquent\Model as Eloquent;

/**
 * Class Soft.
 *
 * @property \Carbon\Carbon $deleted_at
 */
class Soft extends Eloquent
{
    use SoftDeletes;

    protected $connection = 'mongodb';
    protected $collection = 'soft';
    protected static $unguarded = true;
    protected $dates = ['deleted_at'];
}
