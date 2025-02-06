<?php

declare(strict_types=1);

namespace Ghostwriter\Result\Exception;

use Ghostwriter\Result\Interface\ExceptionInterface;
use LogicException;

final class ShouldNotHappenException extends LogicException implements ExceptionInterface {}
