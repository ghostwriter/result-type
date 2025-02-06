<?php

declare(strict_types=1);

namespace Ghostwriter\Result;

use Closure;
use Ghostwriter\Option\Interface\NoneInterface;
use Ghostwriter\Option\Interface\OptionInterface;
use Ghostwriter\Result\Interface\FailureInterface;
use Ghostwriter\Result\Interface\ResultInterface;
use Ghostwriter\Result\Interface\SuccessInterface;
use Throwable;

final readonly class Result
{
    /**
     * @throws Throwable
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
     * @param OptionInterface<TValue> $option
     *
     * @throws Throwable
     */
    public static function call(callable $closure, OptionInterface $option): ResultInterface
    {
        if ($option instanceof NoneInterface) {
            // / @phpstan-ignore-next-line
            return self::failure(new RuntimeException('Option is None'));
        }

        return self::wrap(
            static function () use ($closure, $option) {
                try {
                    return $closure($option->unwrap());
                } catch (Throwable $throwable) {
                    return $throwable;
                }
            }
        );
    }

    /**
     * @throws Throwable
     */
    public static function failure(Throwable $throwable): FailureInterface
    {
        return Failure::new($throwable);
    }

    /**
     * @throws Throwable
     */
    public static function success(mixed $result): SuccessInterface
    {
        return Success::new($result);
    }

    /**
     * @throws Throwable
     */
    public static function wrap(Closure $closure): ResultInterface
    {
        try {
            return self::new($closure());
        } catch (Throwable $throwable) {
            return self::failure($throwable);
        }
    }
}
