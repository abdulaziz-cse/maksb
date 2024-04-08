<?php

namespace App\Traits;

use ArrayObject;

class FormRequestNullable extends ArrayObject
{
    public function offsetGet($index)
    {
        return $this->offsetExists($index) ? parent::offsetGet($index) : null;
    }
}

trait FormRequestNullableTrait
{
    public function validated($key = null, $default = null)
    {
        $validatedData = parent::validated();

        // Filter the data as needed
        $nullableData = new FormRequestNullable($validatedData);
        return $nullableData;
    }
}
