<?php

namespace AngelBlanco\Mongodb\Tests\models\Cars;

use AngelBlanco\Mongodb\Eloquent\Model;

/**
 * Class CarGarage.
 *
 * @property string|null $rented_owner_id
 */
class CarGarage extends Model
{
    protected $connection = 'mongodb';

    protected $casts = [
        'rented_owner_id' => self::CAST_ID,
    ];

    protected $attributes = [
        'space' => 1,
    ];

    protected $fillable = ['space', 'rented_owner_id'];
}
