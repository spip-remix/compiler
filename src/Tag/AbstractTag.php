<?php

namespace Spip\Component\Compilo\Tag;

use Spip\Component\Compilo\AST\Branch;
use Spip\Component\Compilo\AST\Leaf;
use Spip\Component\Compilo\AST\TreeInterface;

/**
 * Balise abstraite.
 *
 * @author JamesRezo <james@rezo.net>
 */
abstract class AbstractTag extends Leaf
{
    /** Expression régulière par défaut pour parser une #BALISE SPIP */
    protected const REGEXP_GENERALE = '/^(.*)#([A-Z]+)(\*{1,2}?)(.*)$/Uims';
    protected const REGEXP_FILTRE = '/^|filtre{param1, ...params}/';

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

    abstract public function add(TreeInterface $noisette): static;

    public function parse(): TreeInterface
    {
        $success = \preg_match(self::REGEXP_GENERALE, $this->tag, $matches);

        var_dump($matches);

        return new Branch;
    }
}
