<?php

declare(strict_types=1);

namespace Ghostwriter\ResultType;

use Ghostwriter\ResultType\Contract\OptionInterface;
use Ghostwriter\ResultType\Contract\SuccessInterface;
use Throwable;

final class Result extends AbstractResult
{
//    // Serializable::unserialize()
//    public function __serialize(): array
//    {
//        return [];
//    }
//
//    public function __toString(): string
//    {
//        return '';
//    }
//
//    public function __unserialize(array $data): void
//    {
//    }
//    // Success/Failure
//    // Right/Left
//
//    // TryInterface EitherInterface
//
//    // Errors
//
//    public function isFailure(): bool
//    {
//        return $this instanceof FailureInterface;
//    }
//
//    public function isSuccess(): bool
//    {
//        return $this instanceof OptionInterface;
//    }
//
//    public function serialize(): ?string
//    {
//        return null;
//    }
//
//    /**
//     * Success.
//     *
//     * @param mixed $data
//     */
//    public static function success($data): void
//    {
//    }
//
//    /**
//     * @param mixed $data
//     */
//    public function unserialize($data): void
//    {
//        // return null;
//        // Errors
//    }
//
//    // 'serialize', 'unserialize'

    public static function exception(Throwable $throwable): self
    {
        return new self($throwable);
    }

    public function failure(): Failure
    {
        
    }

    public function flatMap(callable $callback): Contract\ResultInterface
    {
        
    }

    public function map(callable $callback): Contract\ResultInterface
    {
        
    }

    public function mapError(callable $callback): Contract\ResultInterface
    {
        
    }

    public function success(): SuccessInterface
    {
        
    }
}
