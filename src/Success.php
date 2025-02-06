<?php

declare(strict_types=1);

namespace Ghostwriter\Result;

use Ghostwriter\Option\Interface\NoneInterface;
use Ghostwriter\Option\Interface\OptionInterface;
use Ghostwriter\Option\None;
use Ghostwriter\Option\Some;
use Ghostwriter\Result\Exception\ResultException;
use Ghostwriter\Result\Interface\FailureInterface;
use Ghostwriter\Result\Interface\ResultInterface;
use Ghostwriter\Result\Interface\SuccessInterface;
use Override;
use Tests\Unit\SuccessTest;
use Throwable;

use function sprintf;

/**
 * Represents the result of successful operation.
 *
 * @template TResult
 *
 * @implements SuccessInterface<TResult>
 *
 * @see SuccessTest
 */
final readonly class Success implements SuccessInterface
{
    /**
     * @var OptionInterface<TResult>
     */
    private OptionInterface $option;

    /**
     * @param TResult $value
     *
     * @throws Throwable
     */
    private function __construct(mixed $value)
    {
        $this->option = Some::nullable($value);
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
        if ($this instanceof FailureInterface) {
            return $this;
        }

        return $result;
    }

    /**
     * Calls $function if the result is Success, otherwise returns the Error value of self.
     *
     * @template TNewValue
     *
     * @param callable(TResult):TNewValue $function
     *
     * @throws Throwable
     *
     * @return ResultInterface<TResult>
     */
    #[Override]
    public function andThen(callable $function): ResultInterface
    {
        return Result::call($function, $this->option);
    }

    /**
     * @throws Throwable
     */
    #[Override]
    public function expect(Throwable $throwable): mixed
    {
        return $this->option->unwrap();
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

    /**
     * @throws Throwable
     */
    #[Override]
    public function get(): mixed
    {
        return $this->option->unwrap();
    }

    /**
     * @throws Throwable
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
     * @template TFallback
     *
     * @param TFallback $fallback
     *
     * @throws Throwable
     *
     * @return TResult
     */
    #[Override]
    public function getOr(mixed $fallback): mixed
    {
        return $this->option->unwrap();
    }

    /**
     * @throws Throwable
     *
     * @return TResult
     */
    #[Override]
    public function getOrElse(callable $function): mixed
    {
        return $this->option->unwrap();
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
        return Result::call($function, $this->option);
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
    public function success(): OptionInterface
    {
        return $this->option;
    }

    //    /**
    //     * @template TNewValue
    //     *
    //     * @param callable(TResult):TNewValue $function
    //     *
    //     * @throws Throwable
    //     */
    //    private function call(callable $function): ResultInterface
    //    {
    //        return Result::call($function, $this->option);
    //    }

    /**
     * @throws Throwable
     */
    public static function of(mixed $value): ResultInterface
    {
        if ($value instanceof ResultInterface) {
            return $value;
        }

        return $value instanceof Throwable ? Failure::new($value) : self::new($value);
    }
}
