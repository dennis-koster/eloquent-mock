<?php

declare(strict_types=1);

namespace DennisKoster\EloquentMock\Assertions;

use Closure;

class MethodAssertion
{
    public function __construct(
        public readonly string $methodName,
        public readonly array $methodArguments = [],
        public readonly Closure | null $methodArgumentsCallback = null,
        public readonly int | null $times = 1,
        public readonly bool $mayBeCalledMoreTimes = false,
        public readonly mixed $returnValue = null,
    ) {
    }
}
