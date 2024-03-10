<?php

namespace Spip\Component\Compilo\Filter;

use Spip\Component\Compilo\Filter\Payload\ArrayPayload;
use Spip\Component\Compilo\Filter\Payload\BooleanPayload;
use Spip\Component\Compilo\Filter\Payload\FloatPayload;
use Spip\Component\Compilo\Filter\Payload\IntegerPayload;
use Spip\Component\Compilo\Filter\Payload\MixedPayload;
use Spip\Component\Compilo\Filter\Payload\NullPayload;
use Spip\Component\Compilo\Filter\Payload\NumericPayload;

class Factory
{
    /** @todo à mettre dans le container avec un tag `spip.compiler.converter` et un ordre */
    protected const SUB_TYPES = [
        'null' => NullPayload::class,
        'bool' => BooleanPayload::class,
        'integer' => IntegerPayload::class,
        'float' => FloatPayload::class,
        'integer or float' => NumericPayload::class,
        'array' => ArrayPayload::class,
        'mixed' => MixedPayload::class,
    ];

    public static function createConverterFromPayload($payload): ?ConverterInterface
    {
        foreach (self::SUB_TYPES as $subType) {
            $subType = new $subType;
            if ($subType->validate($payload)) {
                return $subType;
            }
        }

        return null;
    }

    public static function createConverterFromSubType(string $subType): ?ConverterInterface
    {
        $subTypes = self::SUB_TYPES;

        if (\array_key_exists($subType, $subTypes)) {
            return new $subTypes[$subType];
        }

        // @todo Ttrouver le convertisseur le plus adequat

        return null;
    }
}
