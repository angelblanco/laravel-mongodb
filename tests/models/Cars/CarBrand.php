<?php

namespace AngelBlanco\Mongodb\Tests\models\Cars;

use AngelBlanco\Mongodb\Eloquent\Model;

/**
 * Class CarBrand.
 *
 * @property string $_id
 * @property string $name
 */
class CarBrand extends Model
{
    protected $connection = 'mongodb';

    protected $attributes = [
        'name' => '',
    ];

    protected $fillable = ['name'];
}
