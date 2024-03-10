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
class NumericPayload implements PayloadInterface, ConverterInterface
{
    public string $name = 'integer or float';

    public function __construct(
        private string $subType = '',
    ) {
    }

    public function validate($payload): bool
    {
        return !(\is_null($payload) || \is_bool($payload) || \is_object($payload)) &&
            (
                \is_numeric($payload) ||
                \intval($payload) == $payload ||
                \floatval($payload) == $payload
            ) &&
            $this->validateSubTtype($payload);
    }

    public function subType(): string
    {
        return ($this->subType ? $this->subType . ' ' : '') . $this->name;
    }

    public function convert($payload): string
    {
        return \strval($payload);
    }

    protected function validateSubTtype($payload): bool
    {
        return match ($this->subType) {
            '' => true,
            'positive' => $payload > 0,
            'negative' => $payload < 0,
            'non-positive' => $payload <= 0,
            'non-negative' => $payload >= 0,
            'non-zero' =>  $payload != 0,
        };
    }
}
