<?php

namespace Spip\Component\Compilo\Tag;

use Spip\Component\Compilo\AST\Leaf;

/**
 * Balise abstraite.
 *
 * @author JamesRezo <james@rezo.net>
 */
abstract class AbstractTag extends Leaf implements TagInterface
{
    /**
     * @param string $tag [avant(#BALISE|...filtre{...param})après] ou juste BALISE
     * 
     * la balise peut mentionner une boucle parente dans son nom `#_uneboucle:BALISE`
     * elle peut être étoilée une fois ou deux `#BALISE*` `#BALISE**`
     * à noter que l'avant, l'après et les paramètres des filtres
     * peuvent être des balises
     * l'avant et l'après peuvent contenir des boucles aussi
     */
    public function __construct(
        /** @var non-empty-string $tag */
        private string $tag,
        /** @var int<0,2> $starred */
        private int $starred = 0,
        /** @var string[] $filters */
        private array $filters = [],
        private string $before = '',
        private string $after = '',
        private string $loopReference = '',
    ) {
    }

    abstract public function __toString(): string;
}
