<?php

declare(strict_types=1);

namespace DennisKoster\EloquentMock;

use DennisKoster\EloquentMock\Assertions\GetAttributeMethodAssertion;
use DennisKoster\EloquentMock\Assertions\MethodAssertion;
use Illuminate\Database\Eloquent\Model;
use Mockery;
use Mockery\MockInterface;

class EloquentMock
{
    /** @var MockInterface&Model */
    public readonly MockInterface $mock;

    /**
     * @param class-string $model
     */
    public function __construct(
        public readonly string $model,
    ) {
        $this->mock = Mockery::mock($this->model);
    }

    /**
     * @param class-string $model
     * @param array $attributes
     * @return static
     */
    public static function mock(
        string $model,
        array $attributes = [],
    ): static {
        $instance = new static($model);

        foreach ($attributes as $attribute => $value) {
            if ($value instanceof MethodAssertion) {
                $instance->addMethodAssertion($value);

                continue;
            }

            $instance->addMethodAssertion(
                new GetAttributeMethodAssertion(
                    $attribute,
                    $value,
                ),
            );
        }

        return $instance;
    }

    public function addMethodAssertion(MethodAssertion $assertion): self
    {
        $expectation = $this->mock->shouldReceive($assertion->methodName);

        if ($assertion->methodArguments) {
            $expectation->with(... $assertion->methodArguments);
        }

        if ($assertion->times !== null) {
            if ($assertion->mayBeCalledMoreTimes) {
                $expectation->atLeast();
            }

            $expectation->times($assertion->times);
        }

        if (isset($assertion->returnValue)) {
            $expectation->andReturn($assertion->returnValue);
        }

        return $this;
    }
}
