<?php

declare(strict_types=1);

namespace Ghostwriter\ResultType\Contract;

use RuntimeException;

/**
 * @template TSuccess
 * @template TFailure
 */
interface ResultInterface
{
    /**
     * Get the failure option value.
     *
     * @return ErrorInterface<TFailure>
     */
    public function error(): ErrorInterface;

    /**
     * Flat map over the success value.
     *
     * @param callable(TSuccess): self<TSuccess,TFailure> $callback
     *
     * @return self<TSuccess,TFailure>
     */
    public function flatMap(callable $callback): self;

    /** @throws RuntimeException None has no value. */
    public function get(): mixed;

    public function isError(): bool;

    public function isSuccess(): bool;

    /**
     * Map over the success or error value.
     *
     * @param callable(TSuccess|TFailure): self<TSuccess,TFailure> $callback
     *
     * @return self<TSuccess,TFailure>
     */
    public function map(callable $callback): self;

    /**
     * Get the success option value.
     *
     * @return SuccessInterface<TSuccess>
     */
    public function success(): SuccessInterface;
}
