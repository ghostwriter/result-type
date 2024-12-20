<?php

declare(strict_types=1);

namespace Tests\Unit\Exception;

use Ghostwriter\Result\Exception\ResultException;
use Ghostwriter\Result\Failure;
use Ghostwriter\Result\Success;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use Tests\Unit\AbstractTestCase;
use Throwable;

#[CoversClass(ResultException::class)]
#[UsesClass(Failure::class)]
#[UsesClass(Success::class)]
final class ResultExceptionTest extends AbstractTestCase
{
    /**
     * @throws Throwable
     */
    public function testFailureGet(): void
    {
        $this->expectException(ResultException::class);

        $this->failure->get();
    }

    /**
     * @throws Throwable
     */
    public function testSuccessGetError(): void
    {
        $this->expectException(ResultException::class);

        $this->success->getError();
    }
}
