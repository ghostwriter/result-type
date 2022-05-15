<?php

declare(strict_types=1);

namespace Ghostwriter\ResultType;

use Ghostwriter\ResultType\Contract\ErrorInterface;
use Ghostwriter\ResultType\Contract\ResultInterface;
use Ghostwriter\ResultType\Contract\SuccessInterface;
use Throwable;

/**
 * @template T
 * @template E
 * @extends AbstractResult<T,E>
 */
final class Error extends AbstractResult implements ErrorInterface
{
    private Throwable $throwable;

    public function __construct(Throwable $throwable)
    {
        $this->throwable = $throwable;
    }

    /**
     * Get the error option value.
     *
     * @return ErrorInterface<E>
     */
    public function error(): ErrorInterface
    {
        return $this;
    }

    public function failure(): ErrorInterface
    {
        
    }

    public function flatMap(callable $callback): ResultInterface
    {
        
    }

//
//    /**
//     * Flat map over the success value.
//     *
//     * @template S
//     * @template F
//     *
//     * @param callable(T):\GrahamCampbell\ResultType\Result<S,F> $f
//     *
//     * @return \GrahamCampbell\ResultType\Result<S,F>
//     */
//    public function flatMap(callable $f)
//    {
//        // @var \GrahamCampbell\ResultType\Result<S,F>
//        return self::create($this->value);
//    }
//
//    /**
//     * Map over the success value.
//     *
//     * @template S
//     *
//     * @param callable(T):S $f
//     *
//     * @return \GrahamCampbell\ResultType\Result<S,E>
//     */
//    public function map(callable $f)
//    {
//        return self::create($this->value);
//    }
//
//    /**
//     * Map over the error value.
//     *
//     * @template F
//     *
//     * @param callable(E):F $f
//     *
//     * @return \GrahamCampbell\ResultType\Result<T,F>
//     */
//    public function mapError(callable $f)
//    {
//        return self::create($f($this->value));
//    }
//
//    /**
//     * Get the success option value.
//     *
//     * @return \PhpOption\Option<T>
//     */
//    public function success()
//    {
//        return None::create();
//    }
//
//    public static function throw(Throwable $throwable): self
//    {
//        return new self($throwable);
//    }
    public function get(): void
    {
        
    }

    public function map(callable $callback): ResultInterface
    {
        
    }

    public function mapError(callable $callback): ResultInterface
    {
        
    }

    public function success(): SuccessInterface
    {
        
    }
}
