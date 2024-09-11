<?php

declare(strict_types=1);

namespace DennisKoster\EloquentMock\Assertions;

class GetAttributeMethodAssertion extends MethodAssertion
{
    public function __construct(
        string $attribute,
        mixed $returnValue,
        int | null $times = 1,
        bool $mayBeCalledMoreTimes = true,
    ) {
        parent::__construct(
            methodName: 'getAttribute',
            methodArguments: [$attribute],
            times: $times,
            mayBeCalledMoreTimes: $mayBeCalledMoreTimes,
            returnValue: $returnValue,
        );
    }
}
