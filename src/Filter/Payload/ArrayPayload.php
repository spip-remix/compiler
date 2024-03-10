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
class ArrayPayload implements PayloadInterface, ConverterInterface
{
    public function validate($payload): bool
    {
        /**
         * @todo Gérer:
         *
         * Type[]
         * array<Type>
         * array<int, Type>
         * non-empty-array<Type>
         * non-empty-array<int, Type>
         * list<Type>
         * non-empty-list<Type>
         */
        return \is_array($payload);
    }

    public function subType(): string
    {
        return 'array';
    }

    public function convert($payload): Stringable|string
    {
        return preg_replace(
            [",[\r\n ],m", ',^array\(,', ',\,\)$,'],
            ['', '[', ']'],
            var_export($payload, true)
        );
    }
}
