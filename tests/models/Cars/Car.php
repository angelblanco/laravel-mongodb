<?php

namespace AngelBlanco\Mongodb\Tests\models\Cars;

use AngelBlanco\Mongodb\Eloquent\Model;

/**
 * @property string $brand_id
 * @property string $color
 */
class Car extends Model
{
    protected $connection = 'mongodb';

    protected $attributes = [
        'color' => 'white',
    ];

    protected $casts = [
        'brand_id' => self::CAST_ID,
    ];

    protected $fillable = ['brand_id'];
}
