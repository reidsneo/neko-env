<?php

declare(strict_types=1);

namespace Neko\Env\Util;

use Neko\Env\ResultType\Error;
use Neko\Env\ResultType\Success;
use Neko\Env\Option;

/**
 * @internal
 */
final class Str
{
    /**
     * This class is a singleton.
     *
     * @codeCoverageIgnore
     *
     * @return void
     */
    private function __construct()
    {
        //
    }

    /**
     * Convert a string to UTF-8 from the given encoding.
     *
     * @param string      $input
     * @param string|null $encoding
     *
     * @return \Neko\Env\ResultType\Result<string,string>
     */
    public static function utf8(string $input, string $encoding = null)
    {
        if ($encoding !== null && !\in_array($encoding, \mb_list_encodings(), true)) {
            /** @var \Neko\Env\ResultType\Result<string,string> */
            return Error::create(
                \sprintf('Illegal character encoding [%s] specified.', $encoding)
            );
        }

        /** @var \Neko\Env\ResultType\Result<string,string> */
        return Success::create(
            $encoding === null ? @\mb_convert_encoding($input, 'UTF-8') : @\mb_convert_encoding($input, 'UTF-8', $encoding)
        );
    }

    /**
     * Split the given string into an array of characters.
     *
     * @param string $input
     *
     * @return \Neko\Env\ResultType\Result<string[],string>
     */
    public static function split(string $input)
    {
        $result = \mb_str_split($input, 1, 'UTF-8');

        if ($result === false) {
            /** @var \Neko\Env\ResultType\Result<string[],string> */
            return Error::create('Multibyte split failed.');
        }

        /** @var \Neko\Env\ResultType\Result<string[],string> */
        return Success::create($result);
    }

    /**
     * Search for a given substring of the input.
     *
     * @param string $haystack
     * @param string $needle
     *
     * @return \Neko\Env\Option<int>
     */
    public static function pos(string $haystack, string $needle)
    {
        /** @var \Neko\Env\Option<int> */
        return Option::fromValue(\mb_strpos($haystack, $needle, 0, 'UTF-8'), false);
    }

    /**
     * Grab the specified substring of the input.
     *
     * @param string   $input
     * @param int      $start
     * @param int|null $length
     *
     * @return string
     */
    public static function substr(string $input, int $start, int $length = null)
    {
        return \mb_substr($input, $start, $length, 'UTF-8');
    }

    /**
     * Compute the length of the given string.
     *
     * @param string $input
     *
     * @return int
     */
    public static function len(string $input)
    {
        return \mb_strlen($input, 'UTF-8');
    }
}
