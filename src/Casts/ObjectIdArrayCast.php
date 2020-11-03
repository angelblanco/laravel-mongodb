<?php

namespace AngelBlanco\Mongodb\Casts;

use MongoDB\BSON\ObjectId;
use Illuminate\Support\Arr;
use AngelBlanco\Mongodb\Exceptions\CastingException;
use MongoDB\Driver\Exception\InvalidArgumentException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ObjectIdArrayCast implements CastsAttributes
{
    /**
     * Gets the array of object ids as string.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string                              $key
     * @param mixed                               $value
     * @param array                               $attributes
     *
     * @return array
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return array_map('strval', Arr::wrap($value ?? []));
    }

    /**
     * Sets the attribute as array.
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
        try {
            $ids = array_map(function ($id) use ($key) {
                if (empty($id)) {
                    throw new CastingException('Elements of "'.$key.'"  must be non empty valid ObjectIds');
                }

                return new ObjectId($id);
            }, Arr::wrap($value));

            return [
                $key => $ids,
            ];
        } catch (InvalidArgumentException $throwable) {
            throw new CastingException('Elements of "'.$key.'"  must be valid ObjectIds');
        }
    }
}
