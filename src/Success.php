<?php

declare(strict_types=1);

namespace Ghostwriter\Result;

use Ghostwriter\Result\Contract\SuccessInterface;

/**
 * Represents the result of successful operation.
 *
 * @template TSuccess
 * @extends AbstractResult<TSuccess>
 * @implements SuccessInterface<TSuccess>
 *
 * @see \Ghostwriter\Result\Tests\Unit\SuccessTest
 */
final class Success extends AbstractResult implements SuccessInterface
{
    /**
     * @param TSuccess $value
     */
    public function __construct(mixed $value)
    {
        $this->value = $value;
    }
}
