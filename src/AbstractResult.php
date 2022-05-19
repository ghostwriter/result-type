<?php

declare(strict_types=1);

namespace Ghostwriter\Result;

use Ghostwriter\Option\Contract\OptionInterface;
use Ghostwriter\Option\None;
use Ghostwriter\Option\Some;
use Ghostwriter\Result\Contract\ErrorInterface;
use Ghostwriter\Result\Contract\ResultInterface;
use Ghostwriter\Result\Contract\SuccessInterface;
use Ghostwriter\Result\Exception\ResultException;
use Throwable;

 /**
  * @template TSuccess
  * @implements ResultInterface<TSuccess|Throwable>
  */
 abstract class AbstractResult implements ResultInterface
 {
     /**
      * @var Throwable|TSuccess
      */
     protected mixed $value;

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

         return $function($this->value);
     }

     public function error(): OptionInterface
     {
         if ($this instanceof SuccessInterface) {
             return None::create();
         }

         return Some::create($this->value);
     }

     public function expect(Throwable $throwable): mixed
     {
         if ($this instanceof SuccessInterface) {
             return $this->value;
         }

         throw $throwable;
     }

     public function expectError(Throwable $throwable): Throwable
     {
         if ($this instanceof ErrorInterface) {
             /** @var Throwable */
             return $this->value;
         }

         throw $throwable;
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

         return new Success($function($this->value));
     }

     public function mapError(callable $function): ResultInterface
     {
         if ($this instanceof SuccessInterface) {
             return $this;
         }

         /** @var Throwable $value */
         $value = $this->value;

         return new Error($function($value));
     }

     public function or(ResultInterface $result): ResultInterface
     {
         if ($this instanceof SuccessInterface) {
             return new Success($this->value);
         }

         return $result;
     }

     public function orElse(callable $function): ResultInterface
     {
         $value = $this->value;
         if ($this instanceof SuccessInterface) {
             return new Success($value);
         }

         /** @var Throwable $value */
         return $function($value);
     }

     public function success(): OptionInterface
     {
         if ($this instanceof SuccessInterface) {
             return Some::create($this->value);
         }

         return None::create();
     }

     public function unwrap(): mixed
     {
         if ($this instanceof SuccessInterface) {
             return $this->value;
         }

         throw ResultException::invalidMethodCall('unwrap', ErrorInterface::class);
     }

     public function unwrapError(): mixed
     {
         if ($this instanceof ErrorInterface) {
             return $this->value;
         }

         throw ResultException::invalidMethodCall('unwrapError', SuccessInterface::class);
     }

     public function unwrapOr(mixed $fallback): mixed
     {
         if ($this instanceof SuccessInterface) {
             return $this->value;
         }

         return $fallback;
     }

     public function unwrapOrElse(callable $function): mixed
     {
         $value = $this->value;
         if ($this instanceof SuccessInterface) {
             return $value;
         }

         /** @var Throwable $value */
         return $function($value);
     }
 }
