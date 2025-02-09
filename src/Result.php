<?php

declare(strict_types=1);

namespace Ghostwriter\Result;

use Ghostwriter\Option\Interface\SomeInterface;
use Ghostwriter\Result\Interface\FailureInterface;
use Ghostwriter\Result\Interface\ResultInterface;
use Ghostwriter\Result\Interface\SuccessInterface;
use Throwable;

final readonly class Result
{
    /**
     * @template TValue
     *
     * @param Throwable|TValue $value
     *
     * @throws Throwable
     *
     * @return ResultInterface<TValue>
     */
    public static function new(mixed $value): ResultInterface
    {
        return match (true) {
            $value instanceof ResultInterface=> $value,
            $value instanceof Throwable=> self::failure($value),
            default=> self::success($value),
        };
    }

    /**
     * @template TValue
     *
     * @param callable(TValue):ResultInterface<TValue> $closure
     * @param SomeInterface<TValue>                    $option
     *
     * @throws Throwable
     *
     * @return ResultInterface<TValue>
     */
    public static function call(callable $closure, SomeInterface $option): ResultInterface
    {
        try {
            return self::new($closure($option->get()));
        } catch (Throwable $throwable) {
            return self::failure($throwable);
        }
    }

    /**
     * @throws Throwable
     */
    public static function failure(Throwable $throwable): FailureInterface
    {
        return Failure::new($throwable);
    }

    /**
     * @template TValue
     *
     * @param TValue $value
     *
     * @throws Throwable
     *
     * @return SuccessInterface<TValue>
     */
    public static function success(mixed $value): SuccessInterface
    {
        return Success::new($value);
    }
}
