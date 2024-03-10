<?php

/**
 * SPIP
 */

declare(strict_types=1);

namespace Spip\Component\Compilo\Filter\Payload;

/**
 * @api
 */
#[\Attribute(\Attribute::TARGET_METHOD)]
class FloatPayload extends NumericPayload
{
    public string $name ='float';

    public function validate($payload): bool
    {
        return !(\is_null($payload) || \is_bool($payload) || \is_object($payload)) &&
            (\is_float($payload) || \floatval($payload) == $payload) &&
            $this->validateSubTtype($payload);
    }
}
