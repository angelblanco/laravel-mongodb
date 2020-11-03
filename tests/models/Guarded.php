<?php

namespace AngelBlanco\Mongodb\Tests\models;

use AngelBlanco\Mongodb\Eloquent\Model as Eloquent;

class Guarded extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'guarded';
    protected $guarded = ['foobar', 'level1->level2'];
}
