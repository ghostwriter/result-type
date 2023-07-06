<?php

declare(strict_types=1);

namespace Ghostwriter\Result\Tests\Unit;

use Ghostwriter\Option\None;
use Ghostwriter\Option\Some;
use Ghostwriter\Result\AbstractResult;
use Ghostwriter\Result\Error;
use Ghostwriter\Result\ErrorInterface;
use Ghostwriter\Result\Exception\ResultException;
use Ghostwriter\Result\Success;
use Ghostwriter\Result\SuccessInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Throwable;

#[CoversClass(AbstractResult::class)]
#[CoversClass(Success::class)]
#[CoversClass(Error::class)]
final class SuccessTest extends TestCase
{
    private SuccessInterface $success;

    protected function setUp(): void
    {
        $this->success = Success::create(42);
    }

    public function testAnd(): void
    {
        $success = Success::create(true);
        self::assertSame($success, $this->success->and($success));
        self::assertTrue($success->isSuccess());
        self::assertTrue($success->success()->isSome());
        self::assertTrue($success->error()->isNone());
        self::assertTrue($success->unwrap());
    }

    public function testAndThen(): void
    {
        $result = Success::create('foo')
            ->andThen(static fn (string $word): string => $word . 'bar');

        self::assertTrue($result->isSuccess());
        self::assertSame('foobar', $result->unwrap());
    }

    public function testAndThenThrow(): void
    {
        $result = Success::create('foo')
            ->andThen(static fn (): never => throw new RuntimeException());

        self::assertTrue($result->isError());
        self::assertInstanceOf(ErrorInterface::class, $result);
    }

    public function testConstruct(): void
    {
        $success = Success::create('foo');
        self::assertTrue($success->isSuccess());
    }

    public function testError(): void
    {
        self::assertSame(42, $this->success->unwrap());

        self::assertTrue($this->success->isSuccess());

        self::assertInstanceOf(None::class, $this->success->error());
    }

    /**
     *
     * @throws Throwable
     */
    public function testExpect(): void
    {
        $runtimeException = new RuntimeException('oops!');
        self::assertSame(42, $this->success->expect($runtimeException));
    }

    /**
     *
     * @throws Throwable
     */
    public function testExpectError(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('oops!');
        $this->success->expectError(new RuntimeException('oops!'));
    }

    public function testisError(): void
    {
        self::assertFalse($this->success->isError());
    }

    public function testIsSuccess(): void
    {
        self::assertTrue($this->success->isSuccess());
    }

    public function testMap(): void
    {
        $result = $this->success->map(static fn (mixed $x): mixed => $x);
        self::assertTrue($result->isSuccess());
        self::assertNotSame($this->success, $result);

        $mapped = $this->success->map(static fn (mixed $x): int => (int) $x * 10);
        self::assertTrue($mapped->isSuccess());
        self::assertNotSame($this->success, $mapped);
        self::assertSame(420, $mapped->unwrap());
    }

    public function testMapError(): void
    {
        $result = $this->success->mapError(static fn (mixed $x): mixed => $x);
        self::assertTrue($result->isSuccess());
        self::assertSame($this->success, $result);
    }

    public function testOr(): void
    {
        $success = Success::create('foobar');
        $result = $this->success->or($success);

        self::assertTrue($result->isSuccess());
        self::assertSame(42, $result->unwrap());
    }

    public function testOrElse(): void
    {
        $result = $this->success->orElse(static function (): never {
            self::fail('Should not be called!');
        });

        self::assertTrue($result->isSuccess());
        self::assertSame(42, $result->unwrap());
    }

    public function testSuccess(): void
    {
        self::assertInstanceOf(Some::class, $this->success->success());
    }

    public function testUnwrap(): void
    {
        self::assertSame(42, $this->success->unwrap());
    }

    public function testUnwrapError(): void
    {
        $this->expectException(ResultException::class);
        $this->expectExceptionMessage('unwrapError');

        $this->success->unwrapError();
    }

    public function testUnwrapOr(): void
    {
        self::assertSame(42, $this->success->unwrapOr(false));
    }

    public function testUnwrapOrElse(): void
    {
        $fn = static fn (): bool => false;
        self::assertSame(42, $this->success->unwrapOrElse($fn));
    }
}
