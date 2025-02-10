<?php

declare(strict_types=1);

namespace Ghostwriter\Result\Interface;

use Throwable;

/**
 * @template TResult
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
     * @param callable(TResult):TNewValue $function
     *
     * @return self<TResult>
     */
    public function andThen(callable $function): self;

    /**
     * Gets a result, yielding the content of a Success.
     *
     * @throws Throwable
     */
    public function expect(Throwable $throwable): mixed;

    /**
     * Gets a result, yielding the content of an Error.
     *
     * @throws Throwable
     */
    public function expectError(Throwable $throwable): Throwable;

    /**
     * Gets a result, yielding the content of a Success.
     *
     * @return TResult
     */
    public function get(): mixed;

    /**
     * Gets a result, yielding the content of an Error.
     *
     * @return TResult
     */
    public function getError(): mixed;

    /**
     * Gets a result, yielding the content of a Success. Else, it returns $fallback.
     *
     * @template TUnwrapOr
     *
     * @param TUnwrapOr $fallback
     *
     * @return TResult|TUnwrapOr
     */
    public function getOr(mixed $fallback): mixed;

    /**
     * Gets a result, yielding the content of a Success. If the value is an Error then it calls $function with its
     * value.
     *
     * @template TUnwrapOrElse
     *
     * @param callable(TResult):TUnwrapOrElse $function
     *
     * @return TResult|TUnwrapOrElse
     */
    public function getOrElse(callable $function): mixed;

    /**
     * Returns true if the result is Error.
     */
    public function isFailure(): bool;

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
     * @param callable(TResult):TMap $function
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
     * @param callable(TResult):TMapError $function
     *
     * @return self<TMapError|TResult>
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
     * @param callable(TResult):TOrElse $function
     *
     * @return self<TOrElse|TResult>
     */
    public function orElse(callable $function): self;
}
