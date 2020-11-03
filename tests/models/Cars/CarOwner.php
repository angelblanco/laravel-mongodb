<?php

namespace AngelBlanco\Mongodb\Tests\models\Cars;

use AngelBlanco\Mongodb\Eloquent\Model;

/**
 * @property $name string
 * @property $car_ids array
 */
class CarOwner extends Model
{
    protected $connection = 'mongodb';

    protected $casts = [
        'car_ids' => self::CAST_ID_ARRAY,
    ];

    protected $attributes = [
        'car_ids' => [],
    ];

    protected $fillable = ['car_ids'];
}
