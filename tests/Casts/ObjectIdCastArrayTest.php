<?php

namespace AngelBlanco\Mongodb\Tests\Casts;

use AngelBlanco\Mongodb\Tests\TestCase;
use AngelBlanco\Mongodb\Tests\models\Cars\Car;
use AngelBlanco\Mongodb\Tests\models\Cars\CarBrand;
use AngelBlanco\Mongodb\Tests\models\Cars\CarOwner;
use AngelBlanco\Mongodb\Exceptions\CastingException;

class ObjectIdCastArrayTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Car::truncate();
        CarOwner::truncate();
        CarBrand::truncate();
    }

    public function testSetsAndGetsArraysOfIds()
    {
        $brand = CarBrand::create([
            'name' => 'Acme',
        ]);

        $blackCar = Car::create([
            'color' => 'black',
            'brand_id' => $brand->_id,
        ]);

        $whiteCar = Car::create([
            'color' => 'white',
            'brand_id' => $brand->_id,
        ]);

        /** @var CarOwner $owner */
        $owner = CarOwner::create([
            'car_ids' => [$blackCar->_id, $whiteCar->_id],
        ]);

        $this->verifyCarOwner(2, $owner);

        $owner->car_ids = [];
        $this->assertIsArray($owner->car_ids);
        $owner->save();
        $owner->refresh();
        $this->verifyCarOwner(0, $owner);

        $owner->car_ids = $whiteCar->_id;
        $owner->save();
        $owner = CarOwner::first();
        $this->verifyCarOwner(1, $owner);
        $this->assertEquals($whiteCar->_id, $owner->car_ids[0]);
    }

    public function testItDoesntAllowInvalidIds()
    {
        $this->expectException(CastingException::class);

        CarOwner::create([
            'car_ids' => ['foo'],
        ]);
    }

    private function verifyCarOwner(int $expectedCount, CarOwner $owner)
    {
        $this->assertIsArray($owner->car_ids);
        $this->assertIsIndexedArray($owner->car_ids);
        $this->assertCount($expectedCount, $owner->car_ids);

        foreach ($owner->car_ids as $carId) {
            $this->assertObjectIdString($carId);
        }

        foreach ($owner->getAttributes()['car_ids'] as $carIdObject) {
            $this->assertObjectId($carIdObject);
        }
    }
}
