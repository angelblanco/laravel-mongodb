<?php

namespace AngelBlanco\Mongodb\Tests\Eloquent;

use AngelBlanco\Mongodb\Tests\TestCase;
use AngelBlanco\Mongodb\Tests\models\Address;

class DsnTest extends TestCase
{
    public function test_dsn_works()
    {
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Collection::class,
            DsnAddress::all()
        );
    }
}

class DsnAddress extends Address
{
    protected $connection = 'dsn_mongodb';
}
