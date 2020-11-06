<?php

declare(strict_types=1);

namespace Neko\Env\Store;

interface StoreInterface
{
    /**
     * Read the content of the environment file(s).
     *
     * @throws \Neko\Env\Exception\InvalidEncodingException|\Neko\Env\Exception\InvalidPathException
     *
     * @return string
     */
    public function read();
}
