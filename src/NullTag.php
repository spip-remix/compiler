<?php

namespace Spip\Component\Compilo;

use Spip\Component\Compilo\Tag\TagInterface;

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
class NullTag implements TagInterface
{
    public function __toString(): string
    {
        return '';
    }
}
