<?php

namespace Spip\Component\Compilo\Filter\Payload;

use Spip\Component\Compilo\Filter\DecoratedFilter;
use Spip\Component\Compilo\Filter\IdentityFilter;
use Spip\Component\Compilo\Filter\UnknownFilter;
use Spip\Component\Compilo\Filter\Payload;

\class_alias(IdentityFilter::class, 'Spip\Component\Compilo\Filter\UnknownFilter');

class Pipeline
{
    private int $counter = 1;

    /** @var array<string,callable> $filters */
    private array $filters = [];

    /** @var array<string,mixed> $parameters */
    private array $parameters = [];

    /** @var array<string,ConverterInterface[]> $coonverters */
    private array $converters = [];

    /** @var array<string,PayloadInterface[]> $features */
    private array $features = [];

    private function setMethodAndShortName(callable|string $filter): array
    {
        $unknownFilter = 'Spip\Component\Compilo\Filter\UnknownFilter';
        $method = null;
        $shortName = null;

        if (\is_string($filter)) {
            $shortName = $filter;
            if (!\function_exists($filter)) {
                // @todo cas de chaine représentant un callable "tableau"
                // ou une classe invokable
                // pour des classe à méthode "static" ou à instancier
                [$className, $methodName] = \preg_split(',::,', $filter);
                if (!\class_exists($className)) {
                    return [null, $shortName, [new $unknownFilter, 'filter']];
                }
                $c = new \ReflectionClass($className);
                if (!\in_array($methodName, \array_map(
                    fn (\ReflectionMethod $method): string  => $method->name,
                    $c->getMethods()
                ))) {
                    return [null, $shortName, [new $unknownFilter, 'filter']];
                }
                $m = new \ReflectionMethod($filter);
                $public = (bool) ($m->getModifiers() & \ReflectionMethod::IS_PUBLIC);
                if (!$public) {
                    return [null, $shortName, [new $unknownFilter, 'filter']];
                }
                $static = (bool) ($m->getModifiers() & \ReflectionMethod::IS_STATIC);
                $filter = $static ? [$className, $methodName] : [new $className, $methodName];

                // dump([
                //     'className' => $className,
                //     'methodName' => $methodName,
                //     'static' => $static,
                //     'public' => $public,
                // ]);
            }
        }
        if ($filter instanceof \Closure || \is_string($filter)) {
            $method = new \ReflectionFunction($filter);
            $filter = [new DecoratedFilter($filter), 'filter'];
            $shortName = $shortName ?? 'filter' . ($this->counter++);

            return [$method, $shortName, $filter];
        }
        if (\is_array($filter)) {
            $method = new \ReflectionMethod(...$filter);
            $className = $method->getDeclaringClass()->name;
            $methodName = $method->name;
            $shortName = $className . '::' . $methodName;
            return [$method, $shortName, $filter];
        }
        if (\is_object($filter)) {
            $class = new \ReflectionObject($filter);
            // @todo généraliser
            // Ci-dessous, l'exemple d'une classe invokable avec méthode getShortName()
            $method = $class->getMethod('__invoke');
            $shortName = $class->newInstance()->getShortName();
        }

        return [$method, $shortName, $filter];
    }

    public function add(callable|string $filter, mixed ...$parameters): static
    {
        [$method, $shortName, $filter] = $this->setMethodAndShortName($filter);

        $pipeline = clone $this;
        $pipeline->filters[$shortName] = $filter;
        $pipeline->parameters[$shortName] = $parameters;
        $features = $method?->getAttributes(PayloadInterface::class, \ReflectionAttribute::IS_INSTANCEOF) ?? [];
        $pipeline->features[$shortName] = \array_map(function (\ReflectionAttribute $feature) {
            $class = $feature->getName();
            $arguments = $feature->getArguments();

            return new $class(...$arguments);
        }, $features);
        $pipeline->converters[$shortName] = \array_filter(
            $pipeline->features[$shortName],
            function (PayloadInterface $feature) {
                return $feature instanceof PayloadInterface;
            }
        );

        return $pipeline;
    }

    protected function dispatch(string $name, $payload) // $arguments?
    {
        return $payload;
    }

    public function process($payload, bool $throws = true)
    {
        $decoratedPayload = \null;
        $converter = \null;
        if ($payload instanceof Payload) {
            // $decoratedPayload = $payload;
            $converter = $payload->getConverter();
            $payload = $payload->getPayload();
        }

        $payload = $this->dispatch('pre_filter', $payload); // $arguments?

        foreach ($this->filters as $shortName => $filter) {
            $parameters = $this->parameters[$shortName];
            $features = $this->features[$shortName];
            
            // Convertir en fonction de ce que le payload est.
            // if (!\is_null($converter)) {
            //     $payload = $converter->convert($payload);
            // }
            // @todo Convertir le payload en fonction de ce que veulent les filtres
            $converters = $this->converters[$shortName];
            // dump($converters);
            $payload = empty($features) ?
                $filter($payload, ...$parameters) :
                \array_reduce(
                    $features,
                    function ($payload, PayloadInterface $feature) use ($throws, $filter, $parameters, $shortName) {
                        // @todo 
                        if (!$feature->validate($payload)) {
                            if ($throws) {
                                throw new \UnexpectedValueException(sprintf(
                                    'Payload is invalid (filter "%s" require type "%s", "%s" given)',
                                    $shortName,
                                    $feature->subType(),
                                    ($type = \gettype($payload)) == 'double' ? 'float' : $type
                                ));
                            }

                            // @todo tenter une converstion vers le convertisseur le plus adequat
                            
                            // sinon retourner le payload sans le traiter
                            return $decoratedPayload ?? $payload;
                        }

                        return $filter($decoratedPayload ?? $payload, ...$parameters);
                    },
                    $payload
                );
        }

        return $this->dispatch('post_filter', $decoratedPayload ?? $payload); // $arguments?
    }
}
