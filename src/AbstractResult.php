<?php

declare(strict_types=1);

namespace Ghostwriter\Result;

use Ghostwriter\Option\None;
use Ghostwriter\Option\Option;
use Ghostwriter\Option\OptionInterface;
use Ghostwriter\Result\Exception\ResultException;
use Throwable;

/**
 * @template TValue
 *
 * @implements ResultInterface<TValue>
 */
abstract class AbstractResult implements ResultInterface
{
    /**
     * @var OptionInterface<TValue>
     *
     * @readonly
     */
    private OptionInterface $option;

    /**
     * @param TValue $value
     */
    protected function __construct(mixed $value)
    {
        $this->option = Option::create($value);
    }

    public function and(ResultInterface $result): ResultInterface
    {
        if ($this instanceof ErrorInterface) {
            return $this;
        }

        return $result;
    }

    public function andThen(callable $function): ResultInterface
    {
        if ($this instanceof ErrorInterface) {
            return $this;
        }

        return $this->call($function);
    }

    public function error(): OptionInterface
    {
        if ($this instanceof ErrorInterface) {
            return $this->option;
        }

        return None::create();
    }

    public function expect(Throwable $throwable): mixed
    {
        if ($this instanceof ErrorInterface) {
            throw $throwable;
        }

        return $this->option->unwrap();
    }

    public function expectError(Throwable $throwable): Throwable
    {
        if ($this instanceof SuccessInterface) {
            throw $throwable;
        }

        /** @var Throwable $throwable */
        $throwable = $this->option->unwrap();

        return $throwable;
    }

    public function isError(): bool
    {
        return $this instanceof ErrorInterface;
    }

    public function isSuccess(): bool
    {
        return $this instanceof SuccessInterface;
    }

    public function map(callable $function): ResultInterface
    {
        if ($this instanceof ErrorInterface) {
            return $this;
        }

        return $this->call($function);
    }

    public function mapError(callable $function): ResultInterface
    {
        if ($this instanceof SuccessInterface) {
            return $this;
        }

        return $this->call($function);
    }

    public static function of(mixed $value): ResultInterface
    {
        if ($value instanceof ResultInterface) {
            return $value;
        }

        return $value instanceof Throwable ? Error::create($value) : Success::create($value);
    }

    public function or(ResultInterface $result): ResultInterface
    {
        if ($this instanceof SuccessInterface) {
            return $this;
        }

        return $result;
    }

    public function orElse(callable $function): ResultInterface
    {
        if ($this instanceof SuccessInterface) {
            return $this;
        }

        return $this->call($function);
    }

    public function success(): OptionInterface
    {
        if ($this instanceof SuccessInterface) {
            return $this->option;
        }

        return None::create();
    }

    public function unwrap(): mixed
    {
        if ($this instanceof SuccessInterface) {
            return $this->option->unwrap();
        }

        throw new ResultException(sprintf('Invalid method call "unwrap()" on a Result of type %s', static::class));
    }

    public function unwrapError(): mixed
    {
        if ($this instanceof ErrorInterface) {
            return $this->option->unwrap();
        }

        throw new ResultException(
            sprintf('Invalid method call "unwrapError()" on a Result of type %s', static::class)
        );
    }

    public function unwrapOr(mixed $fallback): mixed
    {
        if ($this instanceof SuccessInterface) {
            return $this->option->unwrap();
        }

        return $fallback;
    }

    public function unwrapOrElse(callable $function): mixed
    {
        if ($this instanceof SuccessInterface) {
            return $this->option->unwrap();
        }

        return $this->option->map($function)
            ->unwrap();
    }

    /**
     * @template TNewValue
     *
     * @param callable(TValue):TNewValue $function
     */
    private function call(callable $function): ResultInterface
    {
        try {
            /** @var TValue $value */
            $value = $this->option->unwrap();

            return self::of($function($value));
        } catch (Throwable $throwable) {
            return Error::create($throwable);
        }
    }
}
