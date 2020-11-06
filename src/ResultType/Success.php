<?php

declare(strict_types=1);


namespace Neko\Env\ResultType;

use neko\Env\None;
use neko\Env\Some;

/**
 * @template T
 * @template E
 * @extends \Neko\Env\ResultType\Result<T,E>
 */
final class Success extends Result
{
    /**
     * @var T
     */
    private $value;

    /**
     * Internal constructor for a success value.
     *
     * @param T $value
     *
     * @return void
     */
    private function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Create a new error value.
     *
     * @template S
     *
     * @param S $value
     *
     * @return \Neko\Env\ResultType\Result<S,E>
     */
    public static function create($value)
    {
        return new self($value);
    }

    /**
     * Get the success option value.
     *
     * @return \neko\Env\Option<T>
     */
    public function success()
    {
        return Some::create($this->value);
    }

    /**
     * Map over the success value.
     *
     * @template S
     *
     * @param callable(T):S $f
     *
     * @return \Neko\Env\ResultType\Result<S,E>
     */
    public function map(callable $f)
    {
        return self::create($f($this->value));
    }

    /**
     * Flat map over the success value.
     *
     * @template S
     * @template F
     *
     * @param callable(T):\Neko\Env\ResultType\Result<S,F> $f
     *
     * @return \Neko\Env\ResultType\Result<S,F>
     */
    public function flatMap(callable $f)
    {
        return $f($this->value);
    }

    /**
     * Get the error option value.
     *
     * @return \neko\Env\Option<E>
     */
    public function error()
    {
        return None::create();
    }

    /**
     * Map over the error value.
     *
     * @template F
     *
     * @param callable(E):F $f
     *
     * @return \Neko\Env\ResultType\Result<T,F>
     */
    public function mapError(callable $f)
    {
        return self::create($this->value);
    }
}
