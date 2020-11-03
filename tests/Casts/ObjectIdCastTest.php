<?php

namespace AngelBlanco\Mongodb\Tests\Casts;

use AngelBlanco\Mongodb\Tests\TestCase;
use AngelBlanco\Mongodb\Tests\models\Cars\Car;
use AngelBlanco\Mongodb\Tests\models\Cars\CarBrand;
use AngelBlanco\Mongodb\Tests\models\Cars\CarOwner;
use AngelBlanco\Mongodb\Exceptions\CastingException;
use AngelBlanco\Mongodb\Tests\models\Cars\CarGarage;

class ObjectIdCastTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Car::truncate();
        CarOwner::truncate();
        CarBrand::truncate();
        CarGarage::truncate();
    }

    public function testGetAndSet()
    {
        $firstBrand = CarBrand::create([
            'name' => 'Acme',
        ]);

        $secondBrand = CarBrand::create([
            'name' => 'Php',
        ]);

        Car::create([
            'color' => 'white',
            'brand_id' => $firstBrand->_id,
        ]);

        // Validate date stored in mongo
        $car = Car::where('color', 'white')->first();
        $this->assertObjectIdString($car->brand_id);
        $this->assertObjectId($car->getAttributes()['brand_id']);
        $this->assertEquals($firstBrand->_id, $car->brand_id);

        // Validate custom assignment before saving
        $car->brand_id = $secondBrand->_id;
        $this->assertObjectIdString($car->brand_id);
        $this->assertEquals($secondBrand->_id, $car->brand_id);
        $this->assertObjectId($car->getAttributes()['brand_id']);
    }

    public function testItAllowsNullOnCreation()
    {
        $car = Car::create([
            'brand_id' => null,
        ]);

        $this->assertNull($car->getAttributes()['brand_id']);
    }

    public function testItDoesntAllowBadIds()
    {
        $this->expectException(CastingException::class);
        Car::create([
            'brand_id' => 'foo',
        ]);
    }

    public function testItDoesntEmptyIds()
    {
        $this->expectException(CastingException::class);
        Car::create([
            'brand_id' => '',
        ]);
    }

    public function testItAllowsNullableWhenSet()
    {
        $owner = CarOwner::create([]);

        CarGarage::create([
            'rented_owner_id' => $owner->_id,
            'space' => 1,
        ]);

        CarGarage::create([
            'rented_owner_id' => null,
            'space' => 2,
        ]);

        /** @var CarGarage $garageFirst */
        $garageFirst = CarGarage::where('space', 1)->first();
        /** @var CarGarage $garageSecond */
        $garageSecond = CarGarage::where('space', 2)->first();

        $this->assertObjectIdString($garageFirst->rented_owner_id);
        $this->assertEquals($owner->_id, $garageFirst->rented_owner_id);
        $this->assertNull($garageSecond->rented_owner_id);

        $garageFirst->rented_owner_id = null;
        $this->assertNull($garageSecond->rented_owner_id);
        $garageFirst->refresh();
        $this->assertNull($garageSecond->getAttributes()['rented_owner_id']);
        $this->assertNull($garageSecond->rented_owner_id);
    }
}
