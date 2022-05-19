<?php

declare(strict_types=1);

namespace Ghostwriter\Result\Contract;

use Ghostwriter\Option\Contract\OptionInterface;
use Throwable;

/**
 * @template TSuccess
 */
interface ResultInterface
{
    /**
     * Returns Result if the result is Success, otherwise returns the Error value of self.
     */
    public function and(self $result): self;

    /**
     * Calls $function if the result is Success, otherwise returns the Error value of self.
     *
     * @param callable(Throwable|TSuccess):ResultInterface $function
     */
    public function andThen(callable $function): self;

    /**
     * Converts from Result<T, E> to Option<E>.
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
     * @param callable(TSuccess):TSuccess $function
     */
    public function map(callable $function): self;

    /**
     * Maps a Result<T,E> to Result<T,F> by applying a function to a contained Error value, leaving a Success value
     * untouched.
     *
     * @param callable(Throwable):Throwable $function
     */
    public function mapError(callable $function): self;

    /**
     * Returns $result if the result is Error, otherwise returns the Success value of self.
     */
    public function or(self $result): self;

    /**
     * Calls $function if the result is Error, otherwise returns the Success value of self.
     *
     * @param callable(Throwable):ResultInterface $function
     */
    public function orElse(callable $function): self;

    /**
     * Converts from Result<T, E> to Option<T>.
     */
    public function success(): OptionInterface;

    /**
     * Unwraps a result, yielding the content of a Success.
     */
    public function unwrap(): mixed;

    /**
     * Unwraps a result, yielding the content of an Error.
     */
    public function unwrapError(): mixed;

    /**
     * Unwraps a result, yielding the content of a Success. Else, it returns $fallback.
     */
    public function unwrapOr(mixed $fallback): mixed;

    /**
     * Unwraps a result, yielding the content of a Success. If the value is an Error then it calls $function with its
     * value.
     *
     * @param callable(Throwable):mixed $function
     */
    public function unwrapOrElse(callable $function): mixed;
}
