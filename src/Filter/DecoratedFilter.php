<?php

namespace Spip\Component\Compilo\Filter;

use Stringable;

/**
 * @internal description.
 */
class DecoratedFilter extends AbstractFilter
{
    /** @var callable */
    private $userLandFilter;

    public function __construct(callable $userLandFilter)
    {
        $this->userLandFilter = $userLandFilter;
    }

    public function filter(Stringable|string $text, mixed ...$parameters): Stringable|string
    {
        $filter = $this->userLandFilter;

        return $filter($text, ...$parameters);
    }
}
