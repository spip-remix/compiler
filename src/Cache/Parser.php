<?php

declare(strict_types=1);

namespace Spip\Component\Compilo\Cache;

use Spip\Component\Compilo\AST\Branch;
use Spip\Component\Compilo\AST\TreeInterface;

/**
 * Undocumented class.
 * 
 * @author JamesRezo <james@rezo.net>
 */
class Parser
{
    public function __construct(private string $squelette)
    {
    }

    /**
     * Undocumented function.
     */
    public function getTree(): TreeInterface
    {
        return new Branch($this->squelette);
    }
}
