<?php

declare(strict_types=1);

namespace Ghostwriter\Result\Exception;

use Ghostwriter\Result\Contract\Exception\ResultExceptionInterface;
use RuntimeException;

final class ResultException extends RuntimeException implements ResultExceptionInterface
{
    public static function invalidMethodCall(string $method, string $type): self
    {
        return new self(sprintf('Invalid method call "%s()" on a Result of type %s', $method, $type));
    }
}
