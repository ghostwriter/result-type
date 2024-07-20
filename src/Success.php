<?php

declare(strict_types=1);

namespace Ghostwriter\Result;

use Override;

/**
 * Represents the result of successful operation.
 *
 * @template TValue
 *
 * @extends AbstractResult<TValue>
 *
 * @implements SuccessInterface<TValue>
 *
 * @see Tests\Unit\SuccessTest
 */
final class Success extends AbstractResult implements SuccessInterface
{
    #[Override]
    public static function create(mixed $value): SuccessInterface
    {
        return new self($value);
    }
}
