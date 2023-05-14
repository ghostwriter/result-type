<?php

declare(strict_types=1);

namespace Ghostwriter\Result\Tests\Unit;

use Ghostwriter\Option\SomeInterface;
use Ghostwriter\Option\None;
use Ghostwriter\Option\Some;
use Ghostwriter\Result\Contract\ErrorInterface;
use Ghostwriter\Result\Contract\SuccessInterface;
use Ghostwriter\Result\Error;
use Ghostwriter\Result\Exception\ResultException;
use Ghostwriter\Result\Success;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Throwable;

/**
 * @coversDefaultClass \Ghostwriter\Result\Error
 *
 * @internal
 *
 * @small
 */
final class ErrorTest extends TestCase
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE = 'Testing error result.';

    /**
     * @var ErrorInterface<Throwable>
     */
    private ErrorInterface $error;

    private RuntimeException $runtimeException;

    protected function setUp(): void
    {
        $this->runtimeException = new RuntimeException(self::ERROR_MESSAGE);
        $this->error = Error::create($this->runtimeException);
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::of
     * @covers \Ghostwriter\Result\AbstractResult::and
     * @covers \Ghostwriter\Result\AbstractResult::isError
     * @covers \Ghostwriter\Result\Success::__construct
     * @covers \Ghostwriter\Result\Success::create
     * @covers \Ghostwriter\Result\Error::__construct
     * @covers \Ghostwriter\Result\Error::create
     */
    public function testAnd(): void
    {
        $success = Success::of('foobar');
        $result = $this->error->and($success);

        self::assertTrue($result->isError());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::andThen
     * @covers \Ghostwriter\Result\AbstractResult::call
     * @covers \Ghostwriter\Result\AbstractResult::of
     * @covers \Ghostwriter\Result\AbstractResult::isError
     * @covers \Ghostwriter\Result\Error::__construct
     * @covers \Ghostwriter\Result\Error::create
     */
    public function testAndThen(): void
    {
        $result = $this->error->andThen(static fn (mixed $value): mixed => $value);
        self::assertTrue($result->isError());
        self::assertSame($this->error, $result);
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::isError
     * @covers \Ghostwriter\Result\Error::__construct
     * @covers \Ghostwriter\Result\Error::create
     */
    public function testConstruct(): void
    {
        $error = Error::create($this->runtimeException);
        self::assertTrue($error->isError());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::error
     * @covers \Ghostwriter\Result\Error::__construct
     * @covers \Ghostwriter\Result\Error::create
     */
    public function testError(): void
    {
        self::assertInstanceOf(Some::class, $this->error->error());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::expect
     * @covers \Ghostwriter\Result\Error::__construct
     * @covers \Ghostwriter\Result\Error::create
     *
     * @throws Throwable
     */
    public function testExpect(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('oops!');
        $this->error->expect(new RuntimeException('oops!'));
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::expectError
     * @covers \Ghostwriter\Result\AbstractResult::isError
     * @covers \Ghostwriter\Result\Error::__construct
     * @covers \Ghostwriter\Result\Error::create
     *
     * @throws Throwable
     */
    public function testExpectError(): void
    {
        self::assertSame($this->runtimeException, $this->error->expectError(new RuntimeException('oops!')));
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::isError
     * @covers \Ghostwriter\Result\Error::__construct
     * @covers \Ghostwriter\Result\Error::create
     */
    public function testisError(): void
    {
        self::assertTrue($this->error->isError());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::isSuccess
     * @covers \Ghostwriter\Result\Error::__construct
     * @covers \Ghostwriter\Result\Error::create
     */
    public function testIsSuccess(): void
    {
        self::assertFalse($this->error->isSuccess());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::isError
     * @covers \Ghostwriter\Result\AbstractResult::map
     * @covers \Ghostwriter\Result\AbstractResult::call
     * @covers \Ghostwriter\Result\AbstractResult::of
     * @covers \Ghostwriter\Result\AbstractResult::unwrapError
     * @covers \Ghostwriter\Result\Error::__construct
     * @covers \Ghostwriter\Result\Error::create
     */
    public function testMap(): void
    {
        $result = $this->error->map(static fn (mixed $x): mixed => $x);

        self::assertTrue($result->isError());
        self::assertSame($this->error, $result);
        self::assertSame($this->runtimeException, $result->unwrapError());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::isError
     * @covers \Ghostwriter\Result\AbstractResult::of
     * @covers \Ghostwriter\Result\AbstractResult::call
     * @covers \Ghostwriter\Result\AbstractResult::mapError
     * @covers \Ghostwriter\Result\AbstractResult::unwrapError
     * @covers \Ghostwriter\Result\Error::__construct
     * @covers \Ghostwriter\Result\Error::create
     */
    public function testMapError(): void
    {
        $result = $this->error->mapError(static fn (mixed $x): mixed => $x);

        self::assertNotSame($this->error, $result);

        self::assertTrue($result->isError());

        self::assertSame($this->runtimeException, $result->unwrapError());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::isSuccess
     * @covers \Ghostwriter\Result\AbstractResult::or
     * @covers \Ghostwriter\Result\AbstractResult::unwrap
     * @covers \Ghostwriter\Result\Success::__construct
     * @covers \Ghostwriter\Result\Success::create
     * @covers \Ghostwriter\Result\Error::__construct
     * @covers \Ghostwriter\Result\Error::create
     */
    public function testOr(): void
    {
        $success = Success::create('foobar');
        $result = $this->error->or($success);

        self::assertTrue($result->isSuccess());
        self::assertSame($success, $result);
        self::assertSame('foobar', $result->unwrap());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::isSuccess
     * @covers \Ghostwriter\Result\AbstractResult::orElse
     * @covers \Ghostwriter\Result\AbstractResult::call
     * @covers \Ghostwriter\Result\AbstractResult::of
     * @covers \Ghostwriter\Result\AbstractResult::unwrap
     * @covers \Ghostwriter\Result\Success::__construct
     * @covers \Ghostwriter\Result\Success::create
     * @covers \Ghostwriter\Result\Error::__construct
     * @covers \Ghostwriter\Result\Error::create
     */
    public function testOrElse(): void
    {
        $success = Success::create('foobar');
        $result = $this->error->orElse(static fn (): SuccessInterface => $success);

        self::assertTrue($result->isSuccess());
        self::assertSame($success, $result);
        self::assertSame('foobar', $result->unwrap());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::success
     * @covers \Ghostwriter\Result\Error::__construct
     * @covers \Ghostwriter\Result\Error::create
     */
    public function testSuccess(): void
    {
        self::assertInstanceOf(None::class, $this->error->success());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::unwrap
     * @covers \Ghostwriter\Result\Exception\ResultException::invalidMethodCall
     * @covers \Ghostwriter\Result\Error::__construct
     * @covers \Ghostwriter\Result\Error::create
     */
    public function testUnwrap(): void
    {
        $this->expectException(ResultException::class);
        $this->expectExceptionMessage(
            ResultException::invalidMethodCall('unwrap', ErrorInterface::class)->getMessage()
        );
        $this->error->unwrap();
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::isError
     * @covers \Ghostwriter\Result\AbstractResult::unwrapError
     * @covers \Ghostwriter\Result\Error::__construct
     * @covers \Ghostwriter\Result\Error::create
     */
    public function testUnwrapError(): void
    {
        self::assertSame($this->runtimeException, $this->error->unwrapError());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::unwrapOr
     * @covers \Ghostwriter\Result\Error::__construct
     * @covers \Ghostwriter\Result\Error::create
     */
    public function testUnwrapOr(): void
    {
        self::assertTrue($this->error->unwrapOr(true));
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::error
     * @covers \Ghostwriter\Result\AbstractResult::unwrapOrElse
     * @covers \Ghostwriter\Result\Error::__construct
     * @covers \Ghostwriter\Result\Error::create
     */
    public function testUnwrapOrElse(): void
    {
        $fn = static fn (): bool => true;
        self::assertInstanceOf(SomeInterface::class, $this->error->error());
        self::assertTrue($this->error->unwrapOrElse($fn));
        //        self::assertSame(42, $this->error->unwrapOrElse($fn));
    }
}
