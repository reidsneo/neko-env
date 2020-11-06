<?php

declare(strict_types=1);

namespace Neko\Env\Repository\Adapter;

use Neko\Env\Option;
use Neko\Env\Some;

final class EnvConstAdapter implements AdapterInterface
{
    /**
     * Create a new env const adapter instance.
     *
     * @return void
     */
    private function __construct()
    {
        //
    }

    /**
     * Create a new instance of the adapter, if it is available.
     *
     * @return \Neko\Env\Option<\Neko\Env\Repository\Adapter\AdapterInterface>
     */
    public static function create()
    {
        /** @var \Neko\Env\Option<AdapterInterface> */
        return Some::create(new self());
    }

    /**
     * Read an environment variable, if it exists.
     *
     * @param string $name
     *
     * @return \Neko\Env\Option<string>
     */
    public function read(string $name)
    {
        /** @var \Neko\Env\Option<string> */
        return Option::fromArraysValue($_ENV, $name)
            ->map(static function ($value) {
                if ($value === false) {
                    return 'false';
                }

                if ($value === true) {
                    return 'true';
                }

                return $value;
            })->filter(static function ($value) {
                return \is_string($value);
            });
    }

    /**
     * Write to an environment variable, if possible.
     *
     * @param string $name
     * @param string $value
     *
     * @return bool
     */
    public function write(string $name, string $value)
    {
        $_ENV[$name] = $value;

        return true;
    }

    /**
     * Delete an environment variable, if possible.
     *
     * @param string $name
     *
     * @return bool
     */
    public function delete(string $name)
    {
        unset($_ENV[$name]);

        return true;
    }
}
