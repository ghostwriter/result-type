<?php

declare(strict_types=1);

namespace Ghostwriter\Result;

use Ghostwriter\Option\Interface\NoneInterface;
use Ghostwriter\Option\Interface\SomeInterface;
use Ghostwriter\Option\None;
use Ghostwriter\Option\Some;
use Ghostwriter\Result\Exception\ResultException;
use Ghostwriter\Result\Interface\FailureInterface;
use Ghostwriter\Result\Interface\ResultInterface;
use Override;
use Tests\Unit\FailureTest;
use Throwable;

use function sprintf;

/**
 * Represents the result of an erroneous operation.
 *
 * @template TFailure of Throwable
 *
 * @implements FailureInterface<TFailure>
 *
 * @see FailureTest
 */
final readonly class Failure implements FailureInterface
{
    /**
     * @var SomeInterface<TFailure>
     */
    private SomeInterface $some;

    /**
     * @param TFailure $throwable
     *
     * @throws Throwable
     */
    private function __construct(Throwable $throwable)
    {
        $this->some = Some::new($throwable);
    }

    /**
     * @throws Throwable
     */
    #[Override]
    public static function new(Throwable $throwable): FailureInterface
    {
        return new self($throwable);
    }

    #[Override]
    public function and(ResultInterface $result): self
    {
        return $this;
    }

    #[Override]
    public function andThen(callable $function): self
    {
        return $this;
    }

    /**
     * @throws Throwable
     */
    #[Override]
    public function expect(Throwable $throwable): mixed
    {
        throw $throwable;
    }

    /**
     * @throws Throwable
     */
    #[Override]
    public function expectError(Throwable $throwable): Throwable
    {
        return $this->some->get();
    }

    #[Override]
    public function failure(): SomeInterface
    {
        return $this->some;
    }

    /**
     * @throws Throwable
     *
     * @return never
     */
    #[Override]
    public function get(): mixed
    {
        throw new ResultException(sprintf(
            'Invalid method call "%s()" on a Result of type %s',
            __FUNCTION__,
            self::class
        ));
    }

    /**
     * @throws Throwable
     *
     * @return TFailure
     */
    #[Override]
    public function getError(): mixed
    {
        return $this->some->get();
    }

    #[Override]
    public function getOr(mixed $fallback): mixed
    {
        return $fallback;
    }

    /**
     * @throws Throwable
     */
    #[Override]
    public function getOrElse(callable $function): mixed
    {
        return $this->some
            ->map($function)
            ->get();
    }

    #[Override]
    public function isFailure(): bool
    {
        return true;
    }

    #[Override]
    public function isSuccess(): bool
    {
        return false;
    }

    #[Override]
    public function map(callable $function): self
    {
        return $this;
    }

    /**
     * @throws Throwable
     */
    #[Override]
    public function mapError(callable $function): ResultInterface
    {
        return Result::call($function, $this->some);
    }

    #[Override]
    public function or(ResultInterface $result): ResultInterface
    {
        return $result;
    }

    /**
     * @throws Throwable
     */
    #[Override]
    public function orElse(callable $function): ResultInterface
    {
        return Result::call($function, $this->some);
    }

    #[Override]
    public function success(): NoneInterface
    {
        return None::new();
    }
}
