<?php

/**
 * SPIP
 */

declare(strict_types=1);

namespace Spip\Component\Compilo\Filter\Payload;

use Spip\Component\Compilo\Filter\ConverterInterface;

/**
 * @api
 */
#[\Attribute(\Attribute::TARGET_METHOD)]
class NullPayload implements PayloadInterface, ConverterInterface
{
    public function validate($payload): bool
    {
        return \is_null($payload);
    }

    public function subType(): string
    {
        return 'null';
    }

    public function convert($payload): \Stringable|string
    {
        return '';
    }
}
