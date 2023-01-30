# Result

[![Compliance](https://github.com/ghostwriter/result/actions/workflows/compliance.yml/badge.svg)](https://github.com/ghostwriter/result/actions/workflows/compliance.yml)
[![Supported PHP Version](https://badgen.net/packagist/php/ghostwriter/result?color=8892bf)](https://www.php.net/supported-versions)
[![Type Coverage](https://shepherd.dev/github/ghostwriter/result/coverage.svg)](https://shepherd.dev/github/ghostwriter/result)
[![Latest Version on Packagist](https://badgen.net/packagist/v/ghostwriter/result)](https://packagist.org/packages/ghostwriter/result)
[![Downloads](https://badgen.net/packagist/dt/ghostwriter/result?color=blue)](https://packagist.org/packages/ghostwriter/result)

Provides a **`Result`** type implementation for PHP

## Installation

You can install the package via composer:

``` bash
composer require ghostwriter/result
```

## Usage

```php
use Ghostwriter\Result\Error;
use Ghostwriter\Result\Success;

// --- Success ---
$success = Success::create('Hello world!');
$success->unwrap(); // 'Hello world!'

// --- Error ---
$error = Error::create(new ExampleException());
$error->unwrap(); // throws: ResultException
$error->unwrapOr('Fallback'); // 'Fallback'
$error->unwrapError(); // returns: instance of ExampleException

// --- Example ---
function divide(int $x, int $y): ResultInterface
{
    if ($y === 0) {
        return Error::create(new DivisionByZeroError);
    }

    return Success::create($x / $y);
}

divide(1, 0); // Error(DivisionByZeroError)
divide(1, 1); // Success(1)
```

## API

### `SuccessInterface`
``` php
/**
 * @template TValue
 *
 * @implements ResultInterface<TValue>
 */
interface SuccessInterface extends ResultInterface
{
    /**
     * Create a new success value.
     *
     * @template TSuccess
     *
     * @param TSuccess $value
     *
     * @return self<TSuccess>
     */
    public static function create(mixed $value): self;
}
```

### `ErrorInterface`
``` php
use Throwable;

/**
 * @template TValue of Throwable
 *
 * @implements ResultInterface<Throwable>
 */
interface ErrorInterface extends ResultInterface
{
    /**
     * Create a new error value.
     *
     * @return self<Throwable>
     */
    public static function create(Throwable $throwable): self;
}
```

### `ResultInterface`
``` php
use Ghostwriter\Option\Contract\OptionInterface;
use Throwable;

/**
 * @template TValue
 */
interface ResultInterface
{
    /**
     * Returns $result if the result is Success, otherwise returns the Error value of self.
     *
     * @template TAndValue
     * @param self<TAndValue> $result
     *
     * @return self<TAndValue>
     */
    public function and(self $result): self;

    /**
     * Calls $function if the result is Success, otherwise returns the Error value of self.
     *
     * @template TNewValue
     *
     * @param callable(TValue):TNewValue $function
     *
     * @return self<TValue>
     */
    public function andThen(callable $function): self;

    /**
     * Converts from Result<TValue> to Option<TValue>.
     */
    public function error(): OptionInterface;

    /**
     * Unwraps a result, yielding the content of a Success.
     *
     * @throws Throwable
     */
    public function expect(Throwable $throwable): mixed;

    /**
     * Unwraps a result, yielding the content of an Error.
     *
     * @throws Throwable
     */
    public function expectError(Throwable $throwable): Throwable;

    /**
     * Returns true if the result is Error.
     */
    public function isError(): bool;

    /**
     * Returns true if the result is Success.
     */
    public function isSuccess(): bool;

    /**
     * Maps a Result<T,E> to Result<U,E> by applying a function to a contained Success value, leaving an Error value
     * untouched.
     *
     * @template TMap
     *
     * @param callable(TValue):TMap $function
     *
     * @return self<TMap>
     */
    public function map(callable $function): self;

    /**
     * Maps a Result<T,E> to Result<T,F> by applying a function to a contained Error value, leaving a Success value
     * untouched.
     *
     * @template TMapError
     *
     * @param callable(TValue):TMapError $function
     *
     * @return self<TMapError|TValue>
     */
    public function mapError(callable $function): self;

    /**
     * Returns $result if the result is Error, otherwise returns the Success value of self.
     */
    public function or(self $result): self;

    /**
     * Calls $function if the result is Error, otherwise returns the Success value of self.
     *
     * @template TOrElse
     *
     * @param callable(TValue):TOrElse $function
     *
     * @return self<TOrElse|TValue>
     */
    public function orElse(callable $function): self;

    /**
     * Converts from Result<TValue> to Option<TValue>.
     *
     * @return OptionInterface<TValue>
     */
    public function success(): OptionInterface;

    /**
     * Unwraps a result, yielding the content of a Success.
     *
     * @return TValue
     */
    public function unwrap(): mixed;

    /**
     * Unwraps a result, yielding the content of an Error.
     *
     * @return TValue
     */
    public function unwrapError(): mixed;

    /**
     * Unwraps a result, yielding the content of a Success. Else, it returns $fallback.
     *
     * @template TUnwrapOr
     *
     * @param TUnwrapOr $fallback
     *
     * @return TUnwrapOr|TValue
     */
    public function unwrapOr(mixed $fallback): mixed;

    /**
     * Unwraps a result, yielding the content of a Success. If the value is an Error then it calls $function with its
     * value.
     *
     * @template TUnwrapOrElse
     *
     * @param callable(TValue):TUnwrapOrElse $function
     *
     * @return TUnwrapOrElse|TValue
     */
    public function unwrapOrElse(callable $function): mixed;
}
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG.md](./CHANGELOG.md) for more information what has changed recently.

## Security

If you discover any security related issues, please email `nathanael.esayeas@protonmail.com` instead of using the issue tracker.

## Sponsors

[[`Become a GitHub Sponsor`](https://github.com/sponsors/ghostwriter)]

## Credits

- [Nathanael Esayeas](https://github.com/ghostwriter)
- [All Contributors](https://github.com/ghostwriter/result/contributors)

## License

The BSD-3-Clause. Please see [License File](./LICENSE) for more information.
