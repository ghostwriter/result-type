<?php

declare(strict_types=1);

namespace Ghostwriter\ResultType\Contract;

use Throwable;

/**
 * @template TSuccess
 * @template TFailure
 */
interface ErrorInterface extends ResultInterface
{
    public function __construct(Throwable $throwable);

    public function get(): mixed;
}
