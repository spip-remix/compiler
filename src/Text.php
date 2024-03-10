<?php

namespace Spip\Component\Compilo;

use Spip\Component\Compilo\AST\Leaf;
use Spip\Component\Compilo\Tag\TagInterface;

/**
 * Un texte.
 *
 * @author JamesRezo <james@rezo.net>
 */
class Text extends Leaf implements TagInterface
{
    public function __construct(private string $text = '')
    {
    }

    public function __toString(): string
    {
        return $this->text;
    }
}
