<?php

declare(strict_types=1);

namespace Spip\Component\Compilo\AST;

/**
 * Arbre Syntaxique Abstrait (AST).
 *
 * Design Pattern: Composite
 *
 * @author JamesRezo <james@rezoo.net>
 */
interface TreeInterface
{
    /**
     * Undocumented function.
     */
    public function transpile(): TreeInterface;

    /**
     * Undocumented function.
     *
     * @return non-empty-string
     */
    public function getType(): string;

    /**
     * Undocumented function.
     */
    public function getOriginalContent(): string;

    /**
     * Undocumented function.
     */
    public function getContent(): string;
}
