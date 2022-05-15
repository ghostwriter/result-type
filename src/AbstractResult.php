<?php

declare(strict_types=1);

namespace Ghostwriter\ResultType;

use Ghostwriter\ResultType\Contract\ResultInterface;

abstract class AbstractResult implements ResultInterface
{
//    public static ResultInterface $result;
//
//    /**
//     * Get the error option value.
//     *
//     * @return \PhpOption\Option<E>
//     */
//    abstract public function error(): Option;
//
//    /**
//     * Flat map over the success value.
//     *
//     * @template S
//     * @template F
//     *
//     * @param callable(T):\GrahamCampbell\ResultType\ResultType<S,F> $f
//     *
//     * @return \GrahamCampbell\ResultType\ResultType<S,F>
//     */
//    abstract public function flatMap(callable $f): ResultType;
//
//    /**
//     * True, if this is Failure, false otherwise.
//     */
//    public function isFailure(): bool
//    {
//        return $this instanceof FailureInterface;
//    }
//
//    /**
//     * True, if this is Success, false otherwise.
//     */
//    public function isSuccess(): bool
//    {
//        return $this instanceof OptionInterface;
//    }
//
//    /**
//     * Map over the success value.
//     *
//     * @template S
//     *
//     * @param callable(T):S $f
//     *
//     * @return \GrahamCampbell\ResultType\ResultType<S,E>
//     */
//    abstract public function map(callable $f): ResultType;
//
//    /**
//     * Map over the error value.
//     *
//     * @template F
//     *
//     * @param callable(E):F $f
//     *
//     * @return \GrahamCampbell\ResultType\ResultType<T,F>
//     */
//    abstract public function mapError(callable $f): ResultType;
//
//    // public static function create(string $args): self
//    // {
//    //     return new static();
//    // }
//
//    /**
//     * Get the success option value.
//     *
//     * @return \PhpOption\Option<T>
//     */
//    abstract public function success(): Option;
}
