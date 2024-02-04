<?php

namespace Spip\Component\Compilo;

/**
 * Balise statique qui renvoie une chaine vide.
 *
 * Balise par défaut quand le compilateur ne trouve pas de correspondance entre
 * #XXX et
 * - l'objet XXX implémentant BaliseInterface
 * - ou la suite de fonctions PHP balise_XXX() et balise_XXX_dist()
 *
 * @author JamesRezo <james@rezo.net>
 */
class NullBalise implements BaliseInterface
{
    public function __toString(): string
    {
        return '';
    }
}
