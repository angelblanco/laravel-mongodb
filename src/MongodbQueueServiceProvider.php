<?php

namespace AngelBlanco\Mongodb;

use Illuminate\Support\Facades\DB;
use Illuminate\Queue\QueueServiceProvider;
use AngelBlanco\Mongodb\Queue\Failed\MongoFailedJobProvider;

class MongodbQueueServiceProvider extends QueueServiceProvider
{
    /**
     * {@inheritdoc}
     */
    protected function registerFailedJobServices()
    {
        // Add compatible queue failer if mongodb is configured.
        if (
            'mongodb' ==
            DB::connection(config('queue.failed.database'))->getDriverName()
        ) {
            $this->app->singleton('queue.failer', function ($app) {
                return new MongoFailedJobProvider(
                    $app['db'],
                    config('queue.failed.database'),
                    config('queue.failed.table')
                );
            });
        } else {
            parent::registerFailedJobServices();
        }
    }
}
