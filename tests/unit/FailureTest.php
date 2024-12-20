<?php

declare(strict_types=1);

namespace Tests\Unit;

use Closure;
use Ghostwriter\Option\Interface\SomeInterface;
use Ghostwriter\Option\None;
use Ghostwriter\Option\Some;
use Ghostwriter\Result\Exception\ResultException;
use Ghostwriter\Result\Failure;
use Ghostwriter\Result\Interface\SuccessInterface;
use Ghostwriter\Result\Result;
use Ghostwriter\Result\Success;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use RuntimeException;
use Throwable;

#[CoversClass(Failure::class)]
#[UsesClass(Result::class)]
#[UsesClass(Success::class)]
final class FailureTest extends AbstractTestCase
{
    /**
     * @throws Throwable
     */
    public function testAnd(): void
    {
        $success = Success::of('foobar');
        $result = $this->failure->and($success);

        self::assertTrue($result->isFailure());
    }

    /**
     * @throws Throwable
     */
    public function testAndThen(): void
    {
        $result = $this->failure->andThen(static fn (mixed $value): mixed => $value);
        self::assertTrue($result->isFailure());
        self::assertSame($this->failure, $result);
    }

    /**
     * @throws Throwable
     */
    public function testAndThenThrow(): void
    {
        $result = $this->failure->andThen(static function (): mixed {
            throw new RuntimeException(__METHOD__);
        });

        self::assertTrue($result->isFailure());
        self::assertSame($this->failure, $result);
    }

    /**
     * @throws Throwable
     */
    public function testConstruct(): void
    {
        $failure = Failure::new($this->runtimeException);
        self::assertTrue($failure->isFailure());
    }

    /**
     * @throws Throwable
     */
    public function testError(): void
    {
        self::assertInstanceOf(Some::class, $this->failure->failure());
    }

    /**
     * @throws Throwable
     */
    public function testExpect(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('oops!');
        $this->failure->expect(new RuntimeException('oops!'));
    }

    /**
     * @throws Throwable
     */
    public function testExpectError(): void
    {
        self::assertSame($this->runtimeException, $this->failure->expectError(new RuntimeException('oops!')));
    }

    /**
     * @throws Throwable
     */
    public function testGet(): void
    {
        $this->expectException(ResultException::class);
        $this->expectExceptionMessage('get');
        $this->failure->get();
    }

    /**
     * @throws Throwable
     */
    public function testGetError(): void
    {
        self::assertSame($this->runtimeException, $this->failure->getError());
    }

    /**
     * @throws Throwable
     */
    public function testGetOr(): void
    {
        self::assertTrue($this->failure->getOr(true));
    }

    /**
     * @throws Throwable
     */
    public function testGetOrElse(): void
    {
        $fn = static fn (): bool
            /**
             * @var bool
             */
            => true;

        self::assertInstanceOf(SomeInterface::class, $this->failure->failure());
        self::assertTrue($this->failure->getOrElse($fn));
    }

    /**
     * @throws Throwable
     */
    public function testIsError(): void
    {
        self::assertTrue($this->failure->isFailure());
    }

    /**
     * @throws Throwable
     */
    public function testIsSuccess(): void
    {
        self::assertFalse($this->failure->isSuccess());
    }

    /**
     * @throws Throwable
     */
    public function testMap(): void
    {
        $result = $this->failure->map(static fn (mixed $x): mixed => $x);

        self::assertTrue($result->isFailure());
        self::assertSame($this->failure, $result);
        self::assertSame($this->runtimeException, $result->getError());
    }

    /**
     * @throws Throwable
     */
    public function testMapError(): void
    {
        $result = $this->failure->mapError(static fn (mixed $x): mixed => $x);

        self::assertNotSame($this->failure, $result);

        self::assertTrue($result->isFailure());

        self::assertSame($this->runtimeException, $result->getError());
    }

    /**
     * @throws Throwable
     */
    public function testOr(): void
    {
        $success = Success::new('foobar');
        $result = $this->failure->or($success);

        self::assertTrue($result->isSuccess());
        self::assertSame($success, $result);
        self::assertSame('foobar', $result->get());
    }

    /**
     * @throws Throwable
     */
    public function testOrElse(): void
    {
        /** @var SuccessInterface $success */
        $success = Success::new('foobar');

        /**
         * @var Closure(): SuccessInterface $orElse
         */
        $orElse = static fn (): SuccessInterface => $success;

        $result = $this->failure->orElse($orElse);

        self::assertTrue($result->isSuccess());
        self::assertSame($success, $result);
        self::assertSame('foobar', $result->get());
    }

    /**
     * @throws Throwable
     */
    public function testSuccess(): void
    {
        self::assertInstanceOf(None::class, $this->failure->success());
    }
}
