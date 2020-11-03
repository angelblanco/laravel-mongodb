<?php

namespace AngelBlanco\Mongodb\Tests\Schema;

use AngelBlanco\Mongodb\Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use AngelBlanco\Mongodb\Tests\models\User;
use AngelBlanco\Mongodb\Tests\seeds\DatabaseSeeder;
use AngelBlanco\Mongodb\Tests\seeds\UserTableSeeder;

class SeederTest extends TestCase
{
    public function tearDown(): void
    {
        User::truncate();
    }

    public function testSeed(): void
    {
        $seeder = new UserTableSeeder();
        $seeder->run();

        $user = User::where('name', 'John Doe')->first();
        $this->assertTrue($user->seed);
    }

    public function testArtisan(): void
    {
        Artisan::call(
            'db:seed --class '.
                str_replace('\\', '\\\\', DatabaseSeeder::class)
        );

        $user = User::where('name', 'John Doe')->first();
        $this->assertTrue($user->seed);
    }
}
