<?php

declare(strict_types=1);

namespace Ghostwriter\Result\Interface;

use Throwable;

/**
 * @template TResult of Throwable
 *
 * @extends ResultInterface<TResult>
 */
interface FailureInterface extends ResultInterface
{
    /**
     * @template TFailure of Throwable
     *
     * @param TFailure $throwable
     *
     * @return self<TFailure>
     */
    public static function new(Throwable $throwable): self;
}
