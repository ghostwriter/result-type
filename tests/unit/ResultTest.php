<?php

declare(strict_types=1);

namespace Tests\Unit;

use Ghostwriter\Result\Failure;
use Ghostwriter\Result\Interface\SuccessInterface;
use Ghostwriter\Result\Result;
use Ghostwriter\Result\Success;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use Throwable;

#[CoversClass(Result::class)]
#[UsesClass(Failure::class)]
#[UsesClass(Success::class)]
final class ResultTest extends AbstractTestCase
{
    /**
     * @throws Throwable
     */
    public function testFailureMapError(): void
    {
        $result = $this->failure->mapError(static fn (mixed $x): mixed => $x);

        self::assertNotSame($this->failure, $result);

        self::assertTrue($result->isFailure());

        self::assertSame($this->runtimeException, $result->getError());
    }

    /**
     * @throws Throwable
     */
    public function testFailureOrElse(): void
    {
        $result = $this->failure->orElse(fn (): SuccessInterface => $this->success);

        self::assertTrue($result->isSuccess());

        self::assertSame($this->success, $result);

        self::assertSame($this->success->get(), $result->get());
    }

    /**
     * @throws Throwable
     */
    public function testSuccessAndThen(): void
    {
        $result = $this->success->andThen(static fn (int $value): string => $value . 'bar');

        self::assertTrue($result->isSuccess());

        self::assertSame('42bar', $result->get());
    }

    /**
     * @throws Throwable
     */
    public function testSuccessMap(): void
    {
        $result = $this->success->map(static fn (mixed $x): mixed => $x);
        self::assertTrue($result->isSuccess());
        self::assertNotSame($this->success, $result);

        $mapped = $this->success->map(static fn (mixed $x): int => (int) $x * 100);
        self::assertTrue($mapped->isSuccess());
        self::assertNotSame($this->success, $mapped);
        self::assertSame(4200, $mapped->get());
    }
}
