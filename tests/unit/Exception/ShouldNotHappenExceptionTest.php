<?php

declare(strict_types=1);

namespace Tests\Unit\Exception;

use Ghostwriter\Result\Exception\ShouldNotHappenException;
use Ghostwriter\Result\Failure;
use Ghostwriter\Result\Success;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use Tests\Unit\AbstractTestCase;

#[CoversClass(ShouldNotHappenException::class)]
#[UsesClass(Failure::class)]
#[UsesClass(Success::class)]
final class ShouldNotHappenExceptionTest extends AbstractTestCase
{
    public function testExample(): void
    {
        self::assertTrue(true);
    }
}
