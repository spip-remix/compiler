<?php

/**
 * SPIP
 */

declare(strict_types=1);

namespace Spip\Component\Compilo\Filter;

/**
 * Undocumented interface.
 *
 * @api
 */
interface FilterInterface extends \Stringable
{
    /**
     * Undocumented function.
     */
    public function getShortName(): string;

    /**
     * Undocumented function.
     */
    public function filter(\Stringable|string $text, mixed ...$parameters): \Stringable|string;
    // public function __invoke(\Stringable|string $text, mixed ...$parameters): \Stringable|string; ?
}
