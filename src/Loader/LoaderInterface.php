<?php

declare(strict_types=1);

namespace Neko\Env\Loader;

use Neko\Env\Repository\RepositoryInterface;

interface LoaderInterface
{
    /**
     * Load the given entries into the repository.
     *
     * @param \Neko\Env\Repository\RepositoryInterface $repository
     * @param \Neko\Env\Parser\Entry[]                 $entries
     *
     * @return array<string,string|null>
     */
    public function load(RepositoryInterface $repository, array $entries);
}
