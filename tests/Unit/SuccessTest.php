<?php

declare(strict_types=1);

namespace Ghostwriter\Result\Tests\Unit;

use Ghostwriter\Option\None;
use Ghostwriter\Option\Some;
use Ghostwriter\Result\Contract\SuccessInterface;
use Ghostwriter\Result\Exception\ResultException;
use Ghostwriter\Result\Success;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Throwable;

/**
 * @coversDefaultClass \Ghostwriter\Result\Success
 *
 * @internal
 *
 * @small
 */
final class SuccessTest extends TestCase
{
    private Success $success;

    protected function setUp(): void
    {
        $this->success =  new Success(42);
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::and
     * @covers \Ghostwriter\Result\Success::__construct
     */
    public function testAnd(): void
    {
        $success = new Success('foobar');
        self::assertSame($success, $this->success->and($success));
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::andThen
     * @covers \Ghostwriter\Result\AbstractResult::isSuccess
     * @covers \Ghostwriter\Result\AbstractResult::unwrap
     * @covers \Ghostwriter\Result\Success::__construct
     */
    public function testAndThen(): void
    {
        $success = new Success('foo');
        $result = $success->andThen(static fn (string $word): Success => new Success($word . 'bar'));
        self::assertTrue($result->isSuccess());
        self::assertSame('foobar', $result->unwrap());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::isSuccess
     * @covers \Ghostwriter\Result\Success::__construct
     */
    public function testConstruct(): void
    {
        $success = new Success('foo');
        self::assertTrue($success->isSuccess());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::error
     * @covers \Ghostwriter\Result\Success::__construct
     */
    public function testError(): void
    {
        self::assertInstanceOf(None::class, $this->success->error());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::expect
     * @covers \Ghostwriter\Result\Success::__construct
     *
     * @throws Throwable
     */
    public function testExpect(): void
    {
        $runtimeException = new RuntimeException('oops!');
        self::assertSame(42, $this->success->expect($runtimeException));
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::expectError
     * @covers \Ghostwriter\Result\AbstractResult::isError
     * @covers \Ghostwriter\Result\Success::__construct
     *
     * @throws Throwable
     */
    public function testExpectError(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('oops!');
        $this->success->expectError(new RuntimeException('oops!'));
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::isError
     * @covers \Ghostwriter\Result\Success::__construct
     */
    public function testIsError(): void
    {
        self::assertFalse($this->success->isError());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::isSuccess
     * @covers \Ghostwriter\Result\Success::__construct
     */
    public function testIsSuccess(): void
    {
        self::assertTrue($this->success->isSuccess());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::isSuccess
     * @covers \Ghostwriter\Result\AbstractResult::map
     * @covers \Ghostwriter\Result\AbstractResult::unwrap
     * @covers \Ghostwriter\Result\Success::__construct
     */
    public function testMap(): void
    {
        $result = $this->success->map(static fn (mixed $x): mixed => $x);
        self::assertTrue($result->isSuccess());
        self::assertNotSame($this->success, $result);

        $mapped = $this->success->map(static fn (int $x): int => $x * 10);
        self::assertTrue($mapped->isSuccess());
        self::assertNotSame($this->success, $mapped);
        self::assertSame(420, $mapped->unwrap());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::isSuccess
     * @covers \Ghostwriter\Result\AbstractResult::mapError
     * @covers \Ghostwriter\Result\Success::__construct
     */
    public function testMapError(): void
    {
        $result = $this->success->mapError(static fn (mixed $x): mixed => $x);
        self::assertTrue($result->isSuccess());
        self::assertSame($this->success, $result);
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::isSuccess
     * @covers \Ghostwriter\Result\AbstractResult::or
     * @covers \Ghostwriter\Result\AbstractResult::unwrap
     * @covers \Ghostwriter\Result\Success::__construct
     */
    public function testOr(): void
    {
        $success = new Success('foobar');
        $result = $this->success->or($success);

        self::assertTrue($result->isSuccess());
        self::assertSame(42, $result->unwrap());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::isSuccess
     * @covers \Ghostwriter\Result\AbstractResult::orElse
     * @covers \Ghostwriter\Result\AbstractResult::unwrap
     * @covers \Ghostwriter\Result\Success::__construct
     */
    public function testOrElse(): void
    {
        $success = new Success('foobar');
        $result = $this->success->orElse(static fn (): Success => $success);

        self::assertTrue($result->isSuccess());
        self::assertSame(42, $result->unwrap());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::success
     * @covers \Ghostwriter\Result\Success::__construct
     */
    public function testSuccess(): void
    {
        self::assertInstanceOf(Some::class, $this->success->success());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::unwrap
     * @covers \Ghostwriter\Result\Success::__construct
     */
    public function testUnwrap(): void
    {
        self::assertSame(42, $this->success->unwrap());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::isError
     * @covers \Ghostwriter\Result\AbstractResult::unwrapError
     * @covers \Ghostwriter\Result\Exception\ResultException::invalidMethodCall
     * @covers \Ghostwriter\Result\Success::__construct
     */
    public function testUnwrapError(): void
    {
        $this->expectException(ResultException::class);
        $this->expectExceptionMessage(
            ResultException::invalidMethodCall('unwrapError', SuccessInterface::class)->getMessage()
        );

        $this->success->unwrapError();
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::unwrapOr
     * @covers \Ghostwriter\Result\Success::__construct
     */
    public function testUnwrapOr(): void
    {
        self::assertSame(42, $this->success->unwrapOr(false));
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::unwrapOrElse
     * @covers \Ghostwriter\Result\Success::__construct
     */
    public function testUnwrapOrElse(): void
    {
        $fn = static fn (): bool => false;
        self::assertSame(42, $this->success->unwrapOrElse($fn));
    }
}
