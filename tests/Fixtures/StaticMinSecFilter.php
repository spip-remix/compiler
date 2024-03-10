<?php

namespace Acme\Filter;

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
class StaticMinSecFilter
{
    /**
     * @api
     */
    public static function filter(int|float $nb_seconde): string
    {
        if ($nb_seconde < 0) {
            // Pas dans mon scope !
            return '';
        }

        $nb_seconde = \round($nb_seconde);
        $zero = new \DateTimeImmutable('0000-00-00');
        $duration = $zero->add(static::dateinterval($nb_seconde));

        return $zero
            ->diff($duration)
            ->format(static::format($nb_seconde));
    }

    /**
     * @param non-negative-int|non-negative-float $timestamp
     */
    protected static function format(int|float $timestamp): string
    {
        if ($timestamp >= 86400) {
            return '%a %H:%I:%S';
        }

        if ($timestamp >= 3600) {
            return '%H:%I:%S';
        }

        return '%I:%S';
    }

    protected static function dateinterval(int|float $duration): \DateInterval
    {
        return new \DateInterval(sprintf(
            'P%dDT%dS',
            $duration / 86400,
            $duration % 86400
        ));
    }
}
