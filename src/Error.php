<?php

declare(strict_types=1);

namespace Ghostwriter\Result;

use Override;
use Throwable;

/**
 * Represents the result of an erroneous operation.
 *
 * @template TValue of Throwable
 *
 * @extends AbstractResult<TValue>
 *
 * @implements ErrorInterface<TValue>
 *
 * @see Tests\Unit\ErrorTest
 */
final class Error extends AbstractResult implements ErrorInterface
{
    #[Override]
    public static function create(Throwable $throwable): self
    {
        return new self($throwable);
    }
}
