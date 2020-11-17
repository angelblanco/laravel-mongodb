<?php

namespace AngelBlanco\Mongodb\Tests\models;

use DateTimeInterface;
use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use AngelBlanco\Mongodb\Eloquent\HybridRelations;
use AngelBlanco\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * Class User.
 *
 * @property string         $_id
 * @property string         $name
 * @property string         $title
 * @property int            $age
 * @property \Carbon\Carbon $birthday
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class User extends Eloquent implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable;
    use CanResetPassword;
    use HybridRelations;
    use Notifiable;

    protected $connection = 'mongodb';
    protected $dates = ['birthday', 'entry.date'];
    protected static $unguarded = true;

    public function books()
    {
        return $this->hasMany(Book::class, 'author_id');
    }

    public function mysqlBooks()
    {
        return $this->hasMany(MysqlBook::class, 'author_id');
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function role()
    {
        return $this->hasOne(Role::class);
    }

    public function mysqlRole()
    {
        return $this->hasOne(MysqlRole::class);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }

    public function groups()
    {
        return $this->belongsToMany(
            Group::class,
            'groups',
            'users',
            'groups',
            '_id',
            '_id',
            'groups'
        );
    }

    public function photos()
    {
        return $this->morphMany(Photo::class, 'imageable');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format("l jS \of F Y h:i:s A");
    }
}
