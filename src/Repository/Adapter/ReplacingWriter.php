<?php

declare(strict_types=1);

namespace Neko\Env\Repository\Adapter;

final class ReplacingWriter implements WriterInterface
{
    /**
     * The inner writer to use.
     *
     * @var \Neko\Env\Repository\Adapter\WriterInterface
     */
    private $writer;

    /**
     * The inner reader to use.
     *
     * @var \Neko\Env\Repository\Adapter\ReaderInterface
     */
    private $reader;

    /**
     * The record of seen variables.
     *
     * @var array<string,string>
     */
    private $seen;

    /**
     * Create a new replacement writer instance.
     *
     * @param \Neko\Env\Repository\Adapter\WriterInterface $writer
     * @param \Neko\Env\Repository\Adapter\ReaderInterface $reader
     *
     * @return void
     */
    public function __construct(WriterInterface $writer, ReaderInterface $reader)
    {
        $this->writer = $writer;
        $this->reader = $reader;
        $this->seen = [];
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
        if ($this->exists($name)) {
            return $this->writer->write($name, $value);
        }

        // succeed if nothing to do
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
        if ($this->exists($name)) {
            return $this->writer->delete($name);
        }

        // succeed if nothing to do
        return true;
    }

    /**
     * Does the given environment variable exist.
     *
     * Returns true if it currently exists, or existed at any point in the past
     * that we are aware of.
     *
     * @param string $name
     *
     * @return bool
     */
    private function exists(string $name)
    {
        if (isset($this->seen[$name])) {
            return true;
        }

        if ($this->reader->read($name)->isDefined()) {
            $this->seen[$name] = '';

            return true;
        }

        return false;
    }
}
