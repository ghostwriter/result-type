<?php

declare(strict_types=1);

namespace Ghostwriter\Result\Tests\Unit;

use Ghostwriter\Option\None;
use Ghostwriter\Option\Some;
use Ghostwriter\Option\SomeInterface;
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

    public function testAnd(): void
    {
        $success = Success::of('foobar');
        $result = $this->error->and($success);

        self::assertTrue($result->isError());
    }

    public function testAndThen(): void
    {
        $result = $this->error->andThen(static fn (mixed $value): mixed => $value);
        self::assertTrue($result->isError());
        self::assertSame($this->error, $result);
    }

    public function testAndThenThrow(): void
    {
        $result = $this->error->andThen(static fn (): never => throw new RuntimeException());

        self::assertTrue($result->isError());
        self::assertSame($this->error, $result);
    }

    public function testConstruct(): void
    {
        $error = Error::create($this->runtimeException);
        self::assertTrue($error->isError());
    }

    public function testError(): void
    {
        self::assertInstanceOf(Some::class, $this->error->error());
    }

    public function testExpect(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('oops!');
        $this->error->expect(new RuntimeException('oops!'));
    }

    public function testExpectError(): void
    {
        self::assertSame($this->runtimeException, $this->error->expectError(new RuntimeException('oops!')));
    }

    public function testisError(): void
    {
        self::assertTrue($this->error->isError());
    }

    public function testIsSuccess(): void
    {
        self::assertFalse($this->error->isSuccess());
    }

    public function testMap(): void
    {
        $result = $this->error->map(static fn (mixed $x): mixed => $x);

        self::assertTrue($result->isError());
        self::assertSame($this->error, $result);
        self::assertSame($this->runtimeException, $result->unwrapError());
    }

    public function testMapError(): void
    {
        $result = $this->error->mapError(static fn (mixed $x): mixed => $x);

        self::assertNotSame($this->error, $result);

        self::assertTrue($result->isError());

        self::assertSame($this->runtimeException, $result->unwrapError());
    }

    public function testOr(): void
    {
        $success = Success::create('foobar');
        $result = $this->error->or($success);

        self::assertTrue($result->isSuccess());
        self::assertSame($success, $result);
        self::assertSame('foobar', $result->unwrap());
    }

    public function testOrElse(): void
    {
        $success = Success::create('foobar');
        $result = $this->error->orElse(static fn (): SuccessInterface => $success);

        self::assertTrue($result->isSuccess());
        self::assertSame($success, $result);
        self::assertSame('foobar', $result->unwrap());
    }

    public function testSuccess(): void
    {
        self::assertInstanceOf(None::class, $this->error->success());
    }

    public function testUnwrap(): void
    {
        $this->expectException(ResultException::class);
        $this->expectExceptionMessage('unwrap');
        $this->error->unwrap();
    }

    public function testUnwrapError(): void
    {
        self::assertSame($this->runtimeException, $this->error->unwrapError());
    }

    public function testUnwrapOr(): void
    {
        self::assertTrue($this->error->unwrapOr(true));
    }

    public function testUnwrapOrElse(): void
    {
        $fn = static fn (): bool => true;
        self::assertInstanceOf(SomeInterface::class, $this->error->error());
        self::assertTrue($this->error->unwrapOrElse($fn));
        //        self::assertSame(42, $this->error->unwrapOrElse($fn));
    }
}
