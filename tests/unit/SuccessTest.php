<?php

declare(strict_types=1);

namespace Tests\Unit;

use Ghostwriter\Option\None;
use Ghostwriter\Option\Some;
use Ghostwriter\Result\Exception\ResultException;
use Ghostwriter\Result\Failure;
use Ghostwriter\Result\Interface\FailureInterface;
use Ghostwriter\Result\Result;
use Ghostwriter\Result\Success;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use RuntimeException;
use Throwable;

#[CoversClass(Success::class)]
#[UsesClass(Failure::class)]
#[UsesClass(Result::class)]
final class SuccessTest extends AbstractTestCase
{
    /**
     * @throws Throwable
     */
    public function testAnd(): void
    {
        $success = Success::new(true);
        self::assertSame($success, $this->success->and($success));
        self::assertTrue($success->isSuccess());
        self::assertTrue($success->success()->isSome());
        self::assertTrue($success->failure()->isNone());
        self::assertTrue($success->get());
    }

    /**
     * @throws Throwable
     */
    public function testAndThen(): void
    {
        $result = Success::new('foo')
            ->andThen(static fn (string $word): string => $word . 'bar');

        self::assertTrue($result->isSuccess());
        self::assertSame('foobar', $result->get());
    }

    /**
     * @throws Throwable
     */
    public function testAndThenThrow(): void
    {
        $result = Success::new('foo')
            ->andThen(static function (): mixed {
                throw new RuntimeException(__METHOD__);
            });

        self::assertTrue($result->isFailure());
        self::assertInstanceOf(FailureInterface::class, $result);
    }

    /**
     * @throws Throwable
     */
    public function testConstruct(): void
    {
        $success = Success::new('foo');
        self::assertTrue($success->isSuccess());
    }

    /**
     * @throws Throwable
     */
    public function testError(): void
    {
        self::assertSame(42, $this->success->get());

        self::assertTrue($this->success->isSuccess());

        self::assertInstanceOf(None::class, $this->success->failure());
    }

    /**
     * @throws Throwable
     */
    public function testExpect(): void
    {
        $runtimeException = new RuntimeException('oops!');
        self::assertSame(42, $this->success->expect($runtimeException));
    }

    /**
     * @throws Throwable
     */
    public function testExpectError(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('oops!');
        $this->success->expectError(new RuntimeException('oops!'));
    }

    /**
     * @throws Throwable
     */
    public function testGet(): void
    {
        self::assertSame(42, $this->success->get());
    }

    /**
     * @throws Throwable
     */
    public function testGetError(): void
    {
        $this->expectException(ResultException::class);
        $this->expectExceptionMessage('getError');

        $this->success->getError();
    }

    /**
     * @throws Throwable
     */
    public function testGetOr(): void
    {
        self::assertSame(42, $this->success->getOr(false));
    }

    /**
     * @throws Throwable
     */
    public function testGetOrElse(): void
    {
        $fn = static fn (): bool => false;
        self::assertSame(42, $this->success->getOrElse($fn));
    }

    /**
     * @throws Throwable
     */
    public function testIsError(): void
    {
        self::assertFalse($this->success->isFailure());
    }

    /**
     * @throws Throwable
     */
    public function testIsSuccess(): void
    {
        self::assertTrue($this->success->isSuccess());
    }

    /**
     * @throws Throwable
     */
    public function testMap(): void
    {
        $result = $this->success->map(static fn (mixed $x): mixed => $x);
        self::assertTrue($result->isSuccess());
        self::assertNotSame($this->success, $result);

        $mapped = $this->success->map(static fn (mixed $x): int => (int) $x * 10);
        self::assertTrue($mapped->isSuccess());
        self::assertNotSame($this->success, $mapped);
        self::assertSame(420, $mapped->get());
    }

    /**
     * @throws Throwable
     */
    public function testMapError(): void
    {
        $result = $this->success->mapError(static fn (mixed $x): mixed => $x);
        self::assertTrue($result->isSuccess());
        self::assertSame($this->success, $result);
    }

    /**
     * @throws Throwable
     */
    public function testOr(): void
    {
        $success = Success::new('foobar');
        $result = $this->success->or($success);

        self::assertTrue($result->isSuccess());
        self::assertSame(42, $result->get());
    }

    /**
     * @throws Throwable
     */
    public function testOrElse(): void
    {
        $result = $this->success->orElse(static function (): never {
            self::fail('Should not be called!');
        });

        self::assertTrue($result->isSuccess());
        self::assertSame(42, $result->get());
    }

    /**
     * @throws Throwable
     */
    public function testSuccess(): void
    {
        self::assertInstanceOf(Some::class, $this->success->success());
    }
}
