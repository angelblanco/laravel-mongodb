<?php

namespace AngelBlanco\Mongodb\Tests;

use MongoDB\BSON\ObjectId;
use Illuminate\Support\Arr;

trait Asserts
{
    /**
     * Assert object id is string and valid.
     *
     * @param string $id
     */
    protected function assertObjectIdString(string $id): void
    {
        $this->assertNotEmpty($id);
        $this->assertIsString($id);
        $this->assertEquals(strval(new ObjectId($id)), $id);
    }

    /**
     * Asserts all elements in the array are valid object ids and a count greater than 0.
     *
     * @param array $ids
     */
    protected function assertObjectIdArrayString(array $ids): void
    {
        $this->assertGreaterThan(0, count($ids));

        foreach ($ids as $id) {
            $this->assertObjectIdString($id);
        }
    }

    /**
     * Asserts that the id is an Object Id.
     */
    protected function assertObjectId(ObjectId $id): void
    {
        $this->assertInstanceOf(ObjectId::class, $id);
    }

    /**
     * Asserts that the given array in not associative.
     *
     * @param array $array
     */
    protected function assertIsIndexedArray($array): void
    {
        $this->assertTrue(
            is_array($array) && !Arr::isAssoc($array),
            'The array is indexed'
        );
    }
}
