<?php

declare(strict_types=1);

namespace Ghostwriter\Result\Contract;

use Throwable;

/**
 * @implements ResultInterface<Throwable>
 */
interface ErrorInterface extends ResultInterface
{
    public function __construct(Throwable $throwable);
}
