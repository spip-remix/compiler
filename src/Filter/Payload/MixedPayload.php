<?php

/**
 * SPIP
 */

declare(strict_types=1);

namespace Spip\Component\Compilo\Filter\Payload;

use Spip\Component\Compilo\Filter\ConverterInterface;
use Stringable;

/**
 * @api
 */
#[\Attribute(\Attribute::TARGET_METHOD)]
class MixedPayload implements PayloadInterface, ConverterInterface
{
    public function validate($payload): bool
    {
        return true;
    }

    public function subType(): string
    {
        return 'mixed';
    }

    public function convert($payload): Stringable|string
    {
        return preg_replace(
            [",[\r\n ],m", ',^array\(,', ',\,\)$,', ',NULL,'],
            ['', '[', ']', 'null'],
            var_export($payload, true)
        );
    }
}
