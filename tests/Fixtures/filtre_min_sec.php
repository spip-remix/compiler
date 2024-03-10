<?php

/**
 * Calcule le nombre de minutes-secondes à partir d'un entier
 * retourne la durée au format [00:]00:00.
 *
 * @api
 */
function min_sec(int|float $nb_seconde): string
{
    if ($nb_seconde >= 86400 || $nb_seconde < 0) {
        // Pas dans mon scope !
        return '';
    }

    return (new DateTime('0000-00-00'))
        ->add(new DateInterval('PT' . round($nb_seconde) . 'S'))
        ->format($nb_seconde >= 3600 ? 'H:i:s' : 'i:s');
}
