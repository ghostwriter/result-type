<?php

declare(strict_types=1);

namespace Ghostwriter\Result\Contract;

/**
 * @template TSuccess
 * @implements ResultInterface<TSuccess>
 */
interface SuccessInterface extends ResultInterface
{
    public function __construct(mixed $value);
}
