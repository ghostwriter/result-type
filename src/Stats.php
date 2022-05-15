<?php

declare(strict_types=1);

namespace Ghostwriter\ResultType;

use Ghostwriter\ResultType\Contract\NoneInterface;
use Ghostwriter\ResultType\Contract\OptionInterface;
use RuntimeException;
use Throwable;

final class Stats implements NoneInterface
{
    private static ?NoneInterface $instance = null;

    private function __construct()
    {
        // Singleton
    }

    public static function create(): NoneInterface
    {
        return self::$instance ??= new self();
    }

    public function filter(callable $callable): self
    {
        return $this;
    }

    public function filterNot(callable $callable): self
    {
        return $this;
    }

    public function flatMap(callable $callable): self
    {
        return $this;
    }

    /**
     * @param mixed $initialValue
     *
     * @return mixed
     */
    public function foldLeft($initialValue, callable $callable)
    {
        return $initialValue;
    }

    /**
     * @param mixed $initialValue
     *
     * @return mixed
     */
    public function foldRight($initialValue, callable $callable)
    {
        return $initialValue;
    }

    public function forAll(callable $callable): self
    {
        return $this;
    }

    public function get(): void
    {
        throw new RuntimeException('None has no value.');
    }

    public function getIterator(): iterable
    {
        yield;
    }

    /**
     * @return mixed
     */
    public function getOrCall(callable $callable)
    {
        return $callable();
    }

    /**
     * @param mixed $default
     *
     * @return mixed
     */
    public function getOrElse($default)
    {
        return $default;
    }

    /**
     * @throws Throwable
     */
    public function getOrThrow(Throwable $throwable): void
    {
        throw $throwable;
    }

    public function ifDefined(callable $callable): void
    {
        // do nothing in that case.
    }

    public function isDefined(): bool
    {
        return false;
    }

    public function isEmpty(): bool
    {
        return true;
    }

    public function map(callable $callable): self
    {
        return $this;
    }

    public function orElse(OptionInterface $option): OptionInterface
    {
        return $option;
    }

    /**
     * @param mixed $value
     */
    public function reject($value): self
    {
        return $this;
    }

    /**
     * @param mixed $value
     */
    public function select($value): self
    {
        return $this;
    }
}
