<?php

use Spip\Component\Compilo\Filter\IdentityFilter;

function filtre_identite_dist($text)
{
    return (new IdentityFilter)->execute($text);
    // return (new UnknownFilter)->execute($text);
}

/**
 * {@internal Simulation de la fonction SPIP chercher_filtre sans l'autoloading
 * avec un principe de recherche simplifié :
 * filtre_nom => nom => filtre_nom_dist => default}
 */
function chercher_filtre(string $fonction, ?string $default = null): ?string {
    if (!$fonction) {
        return $default;
    }

    foreach (['filtre_' . $fonction, $fonction, 'filtre_' . $fonction . '_dist'] as $fonction) {
        if (function_exists($fonction)) {
            // dump('recherche de "'.$fonction.'":OK');
            return $fonction;
        }
        // dump('recherche de "'.$fonction.'":KO');
    }

    // dump('fallback:"'.$default.'"');
    return $default;
}


function print_tests(string $debut, array $lignes): string
{
    $print = '';
    $longueur_valeur = 5;  // 'Avant'
    $longueur_transfo = 5; // 'Après'

    foreach ($lignes as $valeur => $transfo) {
        $longueur_valeur = max($longueur_valeur, mb_strlen($valeur));
        $longueur_transfo = max($longueur_transfo, mb_strlen($transfo));
    }

    foreach ($lignes as $valeur => $transfo) {
        $print .= sprintf($debut, str_pad($valeur, $longueur_valeur, ' ', STR_PAD_LEFT))
            . str_pad($transfo, $longueur_transfo, ' ', STR_PAD_LEFT)
            . PHP_EOL
        ;
    }

    $print = str_pad('Avant', $longueur_valeur, ' ')
        . ':'
        . str_pad('Après', $longueur_transfo, ' ')
        . PHP_EOL
        . str_repeat('-', $longueur_valeur)
        . ':'
        . str_repeat('-', $longueur_transfo)
        . PHP_EOL
        . $print
    ;
    return $print;
}
