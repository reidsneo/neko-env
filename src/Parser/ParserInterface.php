<?php

declare(strict_types=1);

namespace Neko\Env\Parser;

interface ParserInterface
{
    /**
     * Parse content into an entry array.
     *
     * @param string $content
     *
     * @throws \Neko\Env\Exception\InvalidFileException
     *
     * @return \Neko\Env\Parser\Entry[]
     */
    public function parse(string $content);
}
