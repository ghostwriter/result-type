<?php

declare(strict_types=1);

namespace Ghostwriter\ResultType;

use Ghostwriter\ResultType\Contract\ErrorInterface;
use Ghostwriter\ResultType\Contract\ResultInterface;
use Ghostwriter\ResultType\Contract\SuccessInterface;
use Throwable;
use UnexpectedValueException;
use function is_callable;

/**
 * Represents the result of successful operation.
 *
 * @template    T
 *
 * @implements  ResultInterface<T>
 */
final class Success extends AbstractResult implements SuccessInterface
{
    /** @var mixed */
    private $value;

    /** @param mixed $value */
    public function __construct($value)
    {
        $this->value = $this->validate($value);
    }

    public function get(): mixed
    {
        return is_callable($this->value) ? ($this->value)() : $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function validate($value)
    {
        if ($value instanceof self) {
            /** @var mixed $value */
            $value = $value->get();
        }

        /** @var mixed $value */
        $value = is_callable($value) ? $value() : $value;

        if ($value instanceof ErrorInterface) {
            throw new UnexpectedValueException($value::class . ' $value was provided.');
        }

        if ($value instanceof Throwable) {
            throw new UnexpectedValueException($value::class . ' $value was provided.');
        }

        return $value;
    }
}
