<?php

/**
 * Calcule le nombre de [jours [heures:]]minutes:secondes
 * à partir d'un entier positif ou nul exprimé en secondes (durée).
 *
 * Retourne la durée au format:
 *              , (vide) si la durée est erronée (entier négatiif)
 *         00:00, si la durée est inférieure à 1 heure
 *      00:00:00, si la durée est inférieure à 1 jour
 * ou 0 00:00:00, si la durée est supérieure ou égale à 1 jour
 *
 * @api
 */
function jh_minsec(int|float $nb_seconde): string
{
    if ($nb_seconde < 0) {
        // Pas dans mon scope !
        return '';
    }

    $nb_seconde = round($nb_seconde);
    $zero = new DateTimeImmutable('0000-00-00');
    $duration = $zero->add(_dateinterval($nb_seconde));

    return $zero
        ->diff($duration)
        ->format(_format($nb_seconde));
}

/**
 * {@internal description}
 * 
 * @param non-negative-int $timestamp
 */
function _format(int $timestamp): string
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
 * {@internal description}
 */
function _dateinterval(int $duration): DateInterval
{
    $days = $duration / 86400;
    $seconds = $duration % 86400;

    return new DateInterval(sprintf('P%dDT%dS', $days, $seconds));
}
