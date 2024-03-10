<?php

namespace Spip\Component\Compilo;

use Spip\Component\Compilo\AST\Leaf;
use Spip\Component\Compilo\Tag\TagInterface;

/**
 * La balise #REM.
 *
 * @author JamesRezo <james@rezo.net>
 */
class RemTag extends Leaf implements TagInterface
{
    public function __toString(): string
    {
        return '';
    }
}
