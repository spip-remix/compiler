<?php

namespace Spip\Component\Compilo\Filter;

/**
 * Undocumented interface.
 */
interface ConverterInterface
{
    /**
     * Undocumented function.
     */
    public function convert($payload): \Stringable|string;
}
