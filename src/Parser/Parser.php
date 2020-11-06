<?php

declare(strict_types=1);

namespace Neko\Env\Parser;

use Neko\Env\Exception\InvalidFileException;
use Neko\Env\Util\Regex;
use Neko\Env\ResultType\Result;
use Neko\Env\ResultType\Success;

final class Parser implements ParserInterface
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
    public function parse(string $content)
    {
        return Regex::split("/(\r\n|\n|\r)/", $content)->mapError(static function () {
            return 'Could not split into separate lines.';
        })->flatMap(static function (array $lines) {
            return self::process(Lines::process($lines));
        })->mapError(static function (string $error) {
            throw new InvalidFileException(\sprintf('Failed to parse Neko\Env file. %s', $error));
        })->success()->get();
    }

    /**
     * Convert the raw entries into proper entries.
     *
     * @param string[] $entries
     *
     * @return \Neko\Env\ResultType\Result<\Neko\Env\Parser\Entry[],string>
     */
    private static function process(array $entries)
    {
        return \array_reduce($entries, static function (Result $result, string $raw) {
            return $result->flatMap(static function (array $entries) use ($raw) {
                return EntryParser::parse($raw)->map(static function (Entry $entry) use ($entries) {
                    return \array_merge($entries, [$entry]);
                });
            });
        }, Success::create([]));
    }
}
