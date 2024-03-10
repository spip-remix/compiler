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
class BooleanPayload implements PayloadInterface, ConverterInterface
{
    public function validate($payload): bool
    {
        return \is_bool($payload);
    }

    public function subType(): string
    {
        return 'bool';
    }

    public function convert($payload): \Stringable|string
    {
        return $payload ? ' ' : '';
    }
}
