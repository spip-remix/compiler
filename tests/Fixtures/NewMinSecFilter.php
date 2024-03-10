<?php

namespace Acme\Filter;

use Spip\Component\Compilo\Filter\AbstractFilter;
use Spip\Component\Compilo\Filter\Payload\BooleanPayload;
use Spip\Component\Compilo\Filter\Payload\NumericPayload;

/**
 * Calcule le nombre de [jours [heures:]]minutes:secondes
 * à partir d'un entier positif ou nul exprimé en secondes (durée).
 *
 * Retourne la durée au format:
 *              , (vide) si la durée est erronée (entier négatiif)
 *         00:00, si la durée est inférieure à 1 heure
 *      00:00:00, si la durée est inférieure à 1 jour
 * ou 0 00:00:00, si la durée est supérieure ou égale à 1 jour
 */
class NewMinSecFilter extends AbstractFilter
{
    protected string $shortName = 'new_min_sec';

    #[NumericPayload(subType: 'non-negative')]
    // #[BooleanPayload]
    public function filter(\Stringable|string $nb_seconde, mixed ...$parameters): \Stringable|string
    {
        $nb_seconde = \round($nb_seconde);
        $zero = new \DateTimeImmutable('0000-00-00');
        $duration = $zero->add($this->dateinterval($nb_seconde));

        return $zero
            ->diff($duration)
            ->format($this->format($nb_seconde));
    }

    /**
     * description
     * 
     * @param non-negative-int $timestamp
     */
    protected function format(int $timestamp): string
    {
        if ($timestamp >= 86400) {
            return '%a %H:%I:%S';
        }

        if ($timestamp >= 3600) {
            return '%H:%I:%S';
        }

        return '%I:%S';
    }

    /**
     * description
     */
    protected function dateinterval(int $duration): \DateInterval
    {
        return new \DateInterval(sprintf(
            'P%dDT%dS',
            $duration / 86400,
            $duration % 86400
        ));
    }
}
