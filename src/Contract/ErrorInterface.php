<?php

declare(strict_types=1);

namespace Ghostwriter\Result\Contract;

use Throwable;

/**
 * @template TValue of Throwable
 *
 * @extends ResultInterface<Throwable>
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
