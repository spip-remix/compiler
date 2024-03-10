<?php

/**
 * SPIP
 */

declare(strict_types=1);

namespace Spip\Component\Compilo\Filter\Payload;

use Stringable;

/**
 * @api
 */
#[\Attribute(\Attribute::TARGET_METHOD)]
class IntegerPayload extends NumericPayload
{
    public string $name ='integer';

    public function validate($payload): bool
    {
        return !(\is_null($payload) || \is_bool($payload) || \is_object($payload)) &&
            (\is_int($payload) || \intval($payload) == $payload) &&
            $this->validateSubTtype($payload);
    }
}
