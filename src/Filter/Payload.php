<?php

namespace Spip\Component\Compilo\Filter;

use Spip\Component\Compilo\Filter\Payload\PayloadInterface;

/**
 * @internal description.
 */
final class Payload implements \Stringable
{
    public function __construct(
        private mixed $payload,
        private ?ConverterInterface $converter = null,
        /** @var PayloadInterface[] */
        private array $features = [],
    ) {
        $this->check();
    }

    /**
     * @throws \UnexpectedalueException
     */
    private function check(): void
    {
        // fallback pour un convertisseur
        // mais on peut vouloir ne pas en avoir, donc, peut-être pas forcer ici.
        // Quel est l'intérêt de ne pas vouloir un convertisseur ?
        // if (\is_null($this->converter)) {
        //     $this->converter = Factory::createConverterFromPayload($this->payload);
        // }

        if (empty($this->features)) {
            return;
        }

        try {
            $features = \array_map(function (PayloadInterface $feature) {
                return $feature;
            }, $this->features);
        } catch (\Throwable $th) {
            throw new \UnexpectedValueException(sprintf('One or more feature is invvalid'));
        }

        foreach ($features as $feature) {
            if (!$feature->validate($this->payload)) {
                throw new \UnexpectedValueException(sprintf(
                    'Payload is invalid (must be of "%s" type, "%s" given)',
                    $feature->subType(),
                    ($type = \gettype($this->payload)) == 'double' ? 'float' : $type
                ));
            }
        }

        if (!\is_string($this->payload) || !$this->payload instanceof \Stringable) {
            throw new \UnexpectedValueException(sprintf(
                'Payload is invalid (must be a string or a Stringable object, "%s" given)',
                ($type = \gettype($this->payload)) == 'double' ? 'float' : $type
            ));
        }
    }

    public function getPayload(): mixed
    {
        return $this->payload;
    }

    public function getConverter(): ?ConverterInterface
    {
        return $this->converter;
    }

    /**
     * @return PayloadInterface[]
     */
    public function getFeatures(): array
    {
        return $this->features;
    }

    public function __toString(): string
    {
        return (string) $this->payload;
    }

    /**
     * Undocumented function.
     */
    public function to(string $type): mixed
    {
        if (\in_array($type, ['null', 'bool', 'float', 'integer', 'integer or float'])) {
            return $this->payload ? 1 : 0;
        }

        if ($type == 'array') {
            return !empty($this->payload) ? 1 : 0;
        }

        return null;

    }
}
