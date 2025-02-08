<?php

declare(strict_types=1);

namespace Ghostwriter\Result;

use Ghostwriter\Option\Interface\NoneInterface;
use Ghostwriter\Option\Interface\SomeInterface;
use Ghostwriter\Option\None;
use Ghostwriter\Option\Some;
use Ghostwriter\Result\Exception\ResultException;
use Ghostwriter\Result\Interface\ResultInterface;
use Ghostwriter\Result\Interface\SuccessInterface;
use Override;
use Tests\Unit\SuccessTest;
use Throwable;

use function sprintf;

/**
 * Represents the result of successful operation.
 *
 * @template TValue
 *
 * @implements SuccessInterface<TValue>
 *
 * @see SuccessTest
 */
final readonly class Success implements SuccessInterface
{
    /**
     * @var SomeInterface<TValue>
     */
    private SomeInterface $some;

    /**
     * @param TValue $value
     */
    private function __construct(mixed $value)
    {
        $this->some = Some::new($value);
    }

    #[Override]
    public static function new(mixed $value): SuccessInterface
    {
        return new self($value);
    }

    #[Override]
    public function and(ResultInterface $result): ResultInterface
    {
        return $result;
    }

    #[Override]
    public function andThen(callable $function): ResultInterface
    {
        return Result::call($function, $this->some);
    }

    #[Override]
    public function expect(Throwable $throwable): mixed
    {
        return $this->some->get();
    }

    #[Override]
    public function expectError(Throwable $throwable): Throwable
    {
        throw $throwable;
    }

    #[Override]
    public function failure(): NoneInterface
    {
        return None::new();
    }

    #[Override]
    public function get(): mixed
    {
        return $this->some->get();
    }

    /**
     * @throws Throwable
     *
     * @return never
     */
    #[Override]
    public function getError(): mixed
    {
        throw new ResultException(sprintf(
            'Invalid method call "%s()" on a Result of type %s',
            __FUNCTION__,
            self::class
        ));
    }

    #[Override]
    public function getOr(mixed $fallback): mixed
    {
        return $this->some->get();
    }

    #[Override]
    public function getOrElse(callable $function): mixed
    {
        return $this->some->get();
    }

    #[Override]
    public function isFailure(): bool
    {
        return false;
    }

    #[Override]
    public function isSuccess(): bool
    {
        return true;
    }

    #[Override]
    public function map(callable $function): ResultInterface
    {
        return Result::call($function, $this->some);
    }

    #[Override]
    public function mapError(callable $function): self
    {
        return $this;
    }

    #[Override]
    public function or(ResultInterface $result): self
    {
        return $this;
    }

    #[Override]
    public function orElse(callable $function): self
    {
        return $this;
    }

    #[Override]
    public function success(): SomeInterface
    {
        return $this->some;
    }
}
