<?php

declare(strict_types=1);

namespace Ghostwriter\Result\Contract;

/**
 * @template TValue
 * @implements ResultInterface<TValue>
 */
interface SuccessInterface extends ResultInterface
{
    /**
     * Create a new success value.
     *
     * @template TSuccess
     *
     * @param TSuccess $value
     *
     * @return self<TSuccess>
     */
    public static function create(mixed $value): self;
}
