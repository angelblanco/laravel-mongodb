<?php

namespace AngelBlanco\Mongodb\Tests\models;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use AngelBlanco\Mongodb\Eloquent\HybridRelations;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MysqlRole extends Eloquent
{
    use HybridRelations;

    protected $connection = 'mysql';
    protected $table = 'roles';
    protected static $unguarded = true;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function mysqlUser(): BelongsTo
    {
        return $this->belongsTo('MysqlUser');
    }

    /**
     * Check if we need to run the schema.
     */
    public static function executeSchema()
    {
        /** @var \Illuminate\Database\Schema\MySqlBuilder $schema */
        $schema = Schema::connection('mysql');

        if (!$schema->hasTable('roles')) {
            Schema::connection('mysql')->create('roles', function (
                Blueprint $table
            ) {
                $table->string('type');
                $table->string('user_id');
                $table->timestamps();
            });
        }
    }
}
