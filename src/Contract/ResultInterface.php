<?php

declare(strict_types=1);

namespace Ghostwriter\Result\Contract;

use Ghostwriter\Option\OptionInterface;
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
     *
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
