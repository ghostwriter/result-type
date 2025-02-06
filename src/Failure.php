<?php

declare(strict_types=1);

namespace Ghostwriter\Result;

use Ghostwriter\Option\Interface\OptionInterface;
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
     * @var OptionInterface<TFailure>
     */
    private OptionInterface $option;

    /**
     * @param TFailure $value
     *
     * @throws Throwable
     */
    private function __construct(Throwable $value)
    {
        $this->option = Some::new($value);
    }

    /**
     * @template TNewFailure of Throwable
     *
     * @param TNewFailure $throwable
     *
     * @throws Throwable
     *
     * @return self<TNewFailure>
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

    /**
     * Calls $function if the result is Success, otherwise returns the Error value of self.
     *
     * @template TNewValue
     *
     * @param callable(TFailure):TNewValue $function
     */
    #[Override]
    public function andThen(callable $function): self
    {
        return $this;
    }

    #[Override]
    public function expect(Throwable $throwable): mixed
    {
        throw $throwable;
    }

    #[Override]
    public function expectError(Throwable $throwable): Throwable
    {
        /** @var Throwable $throwableUnwrapped */
        return $this->option->unwrap();
    }

    #[Override]
    public function failure(): OptionInterface
    {
        return $this->option;
    }

    /**
     * @throws Throwable
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
        return $this->option->unwrap();
    }

    /**
     * @template TFallback
     *
     * @param TFallback $fallback
     *
     * @return TFallback
     */
    #[Override]
    public function getOr(mixed $fallback): mixed
    {
        return $fallback;
    }

    /**
     * @template TGetOrElse
     *
     * @param callable(TFailure):TGetOrElse $function
     *
     * @throws Throwable
     *
     * @return TGetOrElse
     */
    #[Override]
    public function getOrElse(callable $function): mixed
    {
        return $this->option
            ->map($function)
            ->unwrap();
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
        return Result::call($function, $this->option);
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
        return Result::call($function, $this->option);
    }

    #[Override]
    public function success(): OptionInterface
    {
        return None::new();
    }

    //    /**
    //     * @template TNewValue
    //     *
    //     * @param callable(TFailure):TNewValue $function
    //     */
    //    private function call(callable $function): ResultInterface
    //    {
    //        $option = $this->option;
    //
    //        return Result::wrap(
    //            static function () use ($function, $option) {
    //                try {
    //                    return $function($option->unwrap());
    //                } catch (Throwable $throwable) {
    //                    return $throwable;
    //                }
    //            }
    //        );
    //    }
}
