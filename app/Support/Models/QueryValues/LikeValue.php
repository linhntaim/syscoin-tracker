<?php

namespace App\Support\Models\QueryValues;

class LikeValue extends ComparingValue
{
    public function __construct(string $value)
    {
        parent::__construct($value, 'like');
    }

    public function getValue(): string
    {
        return sprintf('%%%s%%', $this->value);
    }
}
