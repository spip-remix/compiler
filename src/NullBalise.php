<?php

namespace Spip\Component\Compilo;

class NullBalise implements BaliseInterface
{
    public function __toString(): string
    {
        return '';
    }
}
