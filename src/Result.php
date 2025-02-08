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

    public static function failure(Throwable $throwable): FailureInterface
    {
        return Failure::new($throwable);
    }

    /**
     * @template TValue
     *
     * @param TValue $value
     *
     * @return SuccessInterface<TValue>
     */
    public static function success(mixed $value): SuccessInterface
    {
        return Success::new($value);
    }
}
