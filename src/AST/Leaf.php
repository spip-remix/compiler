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
class Leaf implements TreeInterface
{
    private bool $parsed = false;

    private string $originalContent;

    private string $before = '';

    private string $after = '';

    public function __construct(
        private string $content = '',
    ) {
        $this->originalContent = $content;
    }

    public function transpile(): TreeInterface
    {
        if ($this->parsed) {
            return $this;
        }

        $leaf = clone $this;

        # code...
        $leaf->content;

        $leaf->parsed = true;

        return $leaf;
    }

    public function getType(): string
    {
        return 'leaf';
    }

    public function getOriginalContent(): string
    {
        return $this->originalContent;
    }

    public function getContent(): string
    {
        return $this->before
            . $this->content
            . $this->after
        ;
    }
}
