<?php

declare(strict_types=1);

namespace Neko\Env\Repository\Adapter;

interface ReaderInterface
{
    /**
     * Read an environment variable, if it exists.
     *
     * @param string $name
     *
     * @return \Neko\Env\Option<string>
     */
    public function read(string $name);
}
