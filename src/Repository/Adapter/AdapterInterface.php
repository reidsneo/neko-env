<?php

declare(strict_types=1);

namespace Neko\Env\Repository\Adapter;

interface AdapterInterface extends ReaderInterface, WriterInterface
{
    /**
     * Create a new instance of the adapter, if it is available.
     *
     * @return \Neko\Env\Option<\Neko\Env\Repository\Adapter\AdapterInterface>
     */
    public static function create();
}
