<?php

declare(strict_types=1);

namespace Ghostwriter\Result\Exception;

use Ghostwriter\Result\ExceptionInterface;
use RuntimeException;

final class ResultException extends RuntimeException implements ExceptionInterface
{
}
