<?php

namespace Spip\Component\Compilo\Loop;

use Spip\Component\Compilo\AST\Branch;
use Spip\Component\Compilo\AST\TreeInterface;

/**
 * Boucle abstraite.
 *
 * @author JamesRezo <james@rezo.net>
 */
abstract class AbstractTag implements LoopInterface, TreeInterface
{
    abstract public function __toString(): string;

    public function parse(): TreeInterface
    {
        return new Branch;
    }
}
