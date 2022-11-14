<?php

namespace App\Support\Models\QueryValues;

class ComparingValue
{
    public function __construct(
        protected mixed  $value,
        protected string $operator = '='
    )
    {
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }
}