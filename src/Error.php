<?php

declare(strict_types=1);

namespace Ghostwriter\Result;

use Ghostwriter\Result\Contract\ErrorInterface;
use Throwable;

/**
 * Represents the result of errorful operation.
 *
 * @extends AbstractResult<Throwable>
 *
 * @see \Ghostwriter\Result\Tests\Unit\ErrorTest
 */
final class Error extends AbstractResult implements ErrorInterface
{
    public function __construct(Throwable $throwable)
    {
        $this->value = $throwable;
    }
}
