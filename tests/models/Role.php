<?php

namespace AngelBlanco\Mongodb\Tests\models;

use AngelBlanco\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Role extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'roles';
    protected static $unguarded = true;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function mysqlUser(): BelongsTo
    {
        return $this->belongsTo(MysqlUser::class);
    }
}
