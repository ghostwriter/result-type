<?php

declare(strict_types=1);

namespace Ghostwriter\Result;

use Ghostwriter\Result\Contract\ErrorInterface;
use Throwable;

/**
 * Represents the result of an erroneous operation.
 *
 * @template TValue of Throwable
 * @extends AbstractResult<TValue>
 * @implements ErrorInterface<TValue>
 *
 * @see \Ghostwriter\Result\Tests\Unit\ErrorTest
 */
final class Error extends AbstractResult implements ErrorInterface
{
    public static function create(Throwable $throwable): self
    {
        return new self($throwable);
    }
}
