<?php

namespace AngelBlanco\Mongodb\Tests\models;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use AngelBlanco\Mongodb\Eloquent\HybridRelations;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MysqlUser extends Eloquent
{
    use HybridRelations;

    protected $connection = 'mysql';
    protected $table = 'users';
    protected static $unguarded = true;

    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'author_id');
    }

    public function role(): HasOne
    {
        return $this->hasOne(Role::class);
    }

    public function mysqlBooks(): HasMany
    {
        return $this->hasMany(MysqlBook::class);
    }

    /**
     * Check if we need to run the schema.
     */
    public static function executeSchema(): void
    {
        /** @var \Illuminate\Database\Schema\MySqlBuilder $schema */
        $schema = Schema::connection('mysql');

        if (!$schema->hasTable('users')) {
            Schema::connection('mysql')->create('users', function (
                Blueprint $table
            ) {
                $table->increments('id');
                $table->string('name');
                $table->timestamps();
            });
        }
    }
}
