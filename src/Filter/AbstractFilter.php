<?php

namespace Spip\Component\Compilo\Filter;

/**
 * @api
 */
abstract class AbstractFilter implements FilterInterface
{
    protected string $shortName;

    protected \Stringable|string $payload = '';

    abstract public function filter(\Stringable|string $text, mixed ...$parameters): \Stringable|string;

    public function __toString(): string
    {
        return $this->filter($this->payload);
    }

    public function execute(\Stringable|string $text, mixed ...$parameters): \Stringable|string
    {
        return $this->filter($text, ...$parameters);
    }

    public function getShortName(): string
    {
        return $this->shortName;
    }
}
