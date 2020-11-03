<?php

namespace AngelBlanco\Mongodb\Tests;

use AngelBlanco\Mongodb\Tests\models\User;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Illuminate\Auth\Passwords\PasswordResetServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use Asserts;

    /**
     * Get application providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getApplicationProviders($app)
    {
        $providers = parent::getApplicationProviders($app);

        unset(
            $providers[
                array_search(PasswordResetServiceProvider::class, $providers)
            ]
        );

        return $providers;
    }

    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \AngelBlanco\Mongodb\MongodbServiceProvider::class,
            \AngelBlanco\Mongodb\MongodbQueueServiceProvider::class,
            \AngelBlanco\Mongodb\Auth\PasswordResetServiceProvider::class,
            \AngelBlanco\Mongodb\Validation\ValidationServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // reset base path to point to our package's src directory
        //$app['path.base'] = __DIR__ . '/../src';

        $config = require 'config/database.php';

        $app['config']->set('app.key', 'ZsZewWyUJ5FsKp9lMwv4tYbNlegQilM7');

        $app['config']->set('database.default', 'mongodb');
        $app['config']->set(
            'database.connections.mysql',
            $config['connections']['mysql']
        );
        $app['config']->set(
            'database.connections.mongodb',
            $config['connections']['mongodb']
        );
        $app['config']->set(
            'database.connections.mongodb2',
            $config['connections']['mongodb']
        );
        $app['config']->set(
            'database.connections.dsn_mongodb',
            $config['connections']['dsn_mongodb']
        );
        $app['config']->set(
            'database.connections.dsn_mongodb_db',
            $config['connections']['dsn_mongodb_db']
        );

        $app['config']->set('auth.model', User::class);
        $app['config']->set('auth.providers.users.model', User::class);
        $app['config']->set('cache.driver', 'array');

        $app['config']->set('queue.default', 'database');
        $app['config']->set('queue.connections.database', [
            'driver' => 'mongodb',
            'table' => 'jobs',
            'queue' => 'default',
            'expire' => 60,
        ]);
        $app['config']->set('queue.failed.database', 'mongodb2');
    }
}
