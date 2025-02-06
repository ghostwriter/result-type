<?php

declare(strict_types=1);

namespace Ghostwriter\Result\Interface;

use Throwable;

/**
 * @template TError of Throwable
 *
 * @extends ResultInterface<TError>
 */
interface FailureInterface extends ResultInterface
{
    /**
     * @template TNewFailure of Throwable
     *
     * @param TNewFailure $throwable
     *
     * @return self<TNewFailure>
     */
    public static function new(Throwable $throwable): self;
}
