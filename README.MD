# Eloquent Mock
This package aims to make mocking eloquent models a breeze. It is built as a wrapper around Mockery with added convenience methods.

## Installation
```shell
composer require dennis-koster/eloquent-mock --dev
```

## Basic usage
To mock an eloquent model, simply call the `mock()` method on `EloquentMock` with the class string of the model you are trying to mock. The second parameter accepts an array with the attributes you expect to be called on the model as the key, and the values as the return value.

```php
use DennisKoster\EloquentMock\EloquentMock;

$user = EloquentMock::mock(User::class, [
    'id'    => 'db1f7a6d-40ad-4eba-81f5-4a0c93e2e178',
    'name'  => 'Hank',
])->mock;
```

Any attribute provided as a simple `key => value` pair will by default create an assertion that expected the `getAttribute` method to be called at least once, with the key of the array as the argument and will return the value.

In other words, the above example is the equivalent of the following:

```php
$user = Mockery::mock(User::class);

$user->shouldReceive('getAttribute')->atLeast()->once()->with('id')->andReturn('db1f7a6d-40ad-4eba-81f5-4a0c93e2e178');
$user->shouldReceive('getAttribute')->atLeast()->once()->with('name')->andReturn('Hank');
```

## Customized assertions
It is also possible to provide instances of the `DennisKoster\EloquentMock\Assertions\MethodAssertion` or `DennisKoster\EloquentMock\Assertions\GetAttributeMethodAssertion` classes when creating the EloquentMock. Using these assertions gives you more control over the expected behaviour.

For instance, let's say we want to assert that the `name` attribute is requested exactly 3 times, and the `getKey()` at least twice.

```php
$user = EloquentMock::mock(User::class, [
    'id'    => 'db1f7a6d-40ad-4eba-81f5-4a0c93e2e178',
    new GetAttributeMethodAssertion('name', 'Hank', times: 3, mayBeCalledMoreTimes: false),
    new MethodAssertion(methodName: 'getKey', returnValue: 'db1f7a6d-40ad-4eba-81f5-4a0c93e2e178', times: 2, mayBeCalledMoreTimes: true),
])->mock;
```
