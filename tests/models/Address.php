<?php

namespace AngelBlanco\Mongodb\Tests\models;

use AngelBlanco\Mongodb\Eloquent\Model as Eloquent;

class Address extends Eloquent
{
    protected $connection = 'mongodb';
    protected static $unguarded = true;
}
