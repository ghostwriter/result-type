<?php

declare(strict_types=1);

namespace Ghostwriter\Result\Tests\Unit;

use Ghostwriter\Option\None;
use Ghostwriter\Option\Some;
use Ghostwriter\Result\Contract\ErrorInterface;
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

    private Error $error;

    private RuntimeException $throwable;

    protected function setUp(): void
    {
        $this->throwable =  new RuntimeException(self::ERROR_MESSAGE);
        $this->error =  new Error($this->throwable);
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::and
     * @covers \Ghostwriter\Result\AbstractResult::isError
     * @covers \Ghostwriter\Result\Success::__construct
     * @covers \Ghostwriter\Result\Error::__construct
     */
    public function testAnd(): void
    {
        $success = new Success('foobar');
        $result = $this->error->and($success);

        self::assertTrue($result->isError());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::andThen
     * @covers \Ghostwriter\Result\AbstractResult::isError
     * @covers \Ghostwriter\Result\Error::__construct
     */
    public function testAndThen(): void
    {
        $result = $this->error->andThen(static fn (mixed $value): Success => new Success($value));
        self::assertTrue($result->isError());
        self::assertSame($this->error, $result);
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::isError
     * @covers \Ghostwriter\Result\Error::__construct
     */
    public function testConstruct(): void
    {
        $error = new Error($this->throwable);
        self::assertTrue($error->isError());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::error
     * @covers \Ghostwriter\Result\Error::__construct
     */
    public function testError(): void
    {
        self::assertInstanceOf(Some::class, $this->error->error());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::expect
     * @covers \Ghostwriter\Result\Error::__construct
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
     *
     * @throws Throwable
     */
    public function testExpectError(): void
    {
        self::assertSame($this->throwable, $this->error->expectError(new RuntimeException('oops!')));
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::isError
     * @covers \Ghostwriter\Result\Error::__construct
     */
    public function testIsError(): void
    {
        self::assertTrue($this->error->isError());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::isSuccess
     * @covers \Ghostwriter\Result\Error::__construct
     */
    public function testIsSuccess(): void
    {
        self::assertFalse($this->error->isSuccess());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::isError
     * @covers \Ghostwriter\Result\AbstractResult::map
     * @covers \Ghostwriter\Result\AbstractResult::unwrapError
     * @covers \Ghostwriter\Result\Error::__construct
     */
    public function testMap(): void
    {
        $result = $this->error->map(static fn (Throwable $x): Throwable => $x);

        self::assertTrue($result->isError());
        self::assertSame($this->error, $result);
        self::assertSame($this->throwable, $result->unwrapError());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::isError
     * @covers \Ghostwriter\Result\AbstractResult::mapError
     * @covers \Ghostwriter\Result\AbstractResult::unwrapError
     * @covers \Ghostwriter\Result\Error::__construct
     */
    public function testMapError(): void
    {
        $result = $this->error->mapError(static fn (mixed $x): mixed => $x);

        self::assertTrue($result->isError());
        self::assertNotSame($this->error, $result);
        self::assertSame($this->throwable, $result->unwrapError());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::isSuccess
     * @covers \Ghostwriter\Result\AbstractResult::or
     * @covers \Ghostwriter\Result\AbstractResult::unwrap
     * @covers \Ghostwriter\Result\Success::__construct
     * @covers \Ghostwriter\Result\Error::__construct
     */
    public function testOr(): void
    {
        $success = new Success('foobar');
        $result = $this->error->or($success);

        self::assertTrue($result->isSuccess());
        self::assertSame($success, $result);
        self::assertSame('foobar', $result->unwrap());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::isSuccess
     * @covers \Ghostwriter\Result\AbstractResult::orElse
     * @covers \Ghostwriter\Result\AbstractResult::unwrap
     * @covers \Ghostwriter\Result\Success::__construct
     * @covers \Ghostwriter\Result\Error::__construct
     */
    public function testOrElse(): void
    {
        $success = new Success('foobar');
        $result = $this->error->orElse(static fn (): Success => $success);

        self::assertTrue($result->isSuccess());
        self::assertSame($success, $result);
        self::assertSame('foobar', $result->unwrap());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::success
     * @covers \Ghostwriter\Result\Error::__construct
     */
    public function testSuccess(): void
    {
        self::assertInstanceOf(None::class, $this->error->success());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::unwrap
     * @covers \Ghostwriter\Result\Exception\ResultException::invalidMethodCall
     * @covers \Ghostwriter\Result\Error::__construct
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
     */
    public function testUnwrapError(): void
    {
        self::assertSame($this->throwable, $this->error->unwrapError());
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::unwrapOr
     * @covers \Ghostwriter\Result\Error::__construct
     */
    public function testUnwrapOr(): void
    {
        self::assertTrue($this->error->unwrapOr(true));
    }

    /**
     * @covers \Ghostwriter\Result\AbstractResult::unwrapOrElse
     * @covers \Ghostwriter\Result\Error::__construct
     */
    public function testUnwrapOrElse(): void
    {
        $fn = static fn (): bool => true;
        self::assertTrue($this->error->unwrapOrElse($fn));
    }
}
