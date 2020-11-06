<?php

declare(strict_types=1);

namespace Neko\Env\Parser;

use Neko\Env\Option;

final class Entry
{
    /**
     * The entry name.
     *
     * @var string
     */
    private $name;

    /**
     * The entry value.
     *
     * @var \Neko\Env\Parser\Value|null
     */
    private $value;

    /**
     * Create a new entry instance.
     *
     * @param string                    $name
     * @param \Neko\Env\Parser\Value|null $value
     *
     * @return void
     */
    public function __construct(string $name, Value $value = null)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Get the entry name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the entry value.
     *
     * @return \Neko\Env\Option<\Neko\Env\Parser\Value>
     */
    public function getValue()
    {
        /** @var \Neko\Env\Option<\Neko\Env\Parser\Value> */
        return Option::fromValue($this->value);
    }
}
