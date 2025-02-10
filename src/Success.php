<?php

declare(strict_types=1);

namespace Ghostwriter\Result;

use Ghostwriter\Option\Interface\SomeInterface;
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
     *
     * @throws Throwable
     */
    private function __construct(mixed $value)
    {
        $this->some = Some::new($value);
    }

    /**
     * @throws Throwable
     */
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

    /**
     * @throws Throwable
     */
    #[Override]
    public function andThen(callable $function): ResultInterface
    {
        return Result::call($function, $this->some);
    }

    /**
     * @throws Throwable
     */
    #[Override]
    public function expect(Throwable $throwable): mixed
    {
        return $this->some->get();
    }

    /**
     * @throws Throwable
     */
    #[Override]
    public function expectError(Throwable $throwable): Throwable
    {
        throw $throwable;
    }

    /**
     * @throws Throwable
     */
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

    /**
     * @throws Throwable
     */
    #[Override]
    public function getOr(mixed $fallback): mixed
    {
        return $this->some->get();
    }

    /**
     * @throws Throwable
     */
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

    /**
     * @throws Throwable
     */
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
}
