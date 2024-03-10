<?php

namespace Spip\Component\Compilo\Filter;

use Spip\Component\Compilo\Filter\Payload\MixedPayload;

class IdentityFilter extends AbstractFilter
{
    #[MixedPayload]
    public function filter(\Stringable|string $text, mixed ...$parameters): \Stringable|string
    {
        // trigger_error('Unknown filter');
        // add SPIP Logger?
        // dump('Unknown filter');

        return $text;
    }
}
