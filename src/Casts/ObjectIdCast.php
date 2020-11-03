<?php

namespace AngelBlanco\Mongodb\Casts;

use MongoDB\BSON\ObjectId;
use AngelBlanco\Mongodb\Exceptions\CastingException;
use MongoDB\Driver\Exception\InvalidArgumentException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ObjectIdCast implements CastsAttributes
{
    /**
     * Gets the object id as string. When the value is falsy it returns null.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string                              $key
     * @param mixed                               $value
     * @param array                               $attributes
     *
     * @return string|null
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return (string) $value ?: null;
    }

    /**
     * Sets the value as object id when te value is null the value is preserved as null in the database. This will
     * happen by default when the attribute is not set.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string                              $key
     * @param mixed                               $value
     * @param array                               $attributes
     *
     * @return mixed|void
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if (null === $value) {
            return null;
        }

        try {
            return new ObjectId($value);
        } catch (InvalidArgumentException $exception) {
            throw new CastingException('The attribute "'.$key.'" must be a valid Object Id representation');
        }
    }
}
