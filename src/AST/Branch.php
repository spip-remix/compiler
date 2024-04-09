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
class Branch implements TreeInterface
{
    /**
     * @var TreeInterface[]
     */
    public array $branches = [];

    public function __construct(
        private string $content = '',
    ) {
    }

    public function transpile(): TreeInterface
    {
        if (\str_contains($this->content, '#NULL')) {
            $this->content = \str_replace('#NULL', 'echo \'appel de la balise null\';', $this->content);
        }

        $branch = clone $this;

        foreach ($this->branches as $subBranch) {
            $subBranch = $subBranch->transpile();
        }

        return $branch;
    }

    public function add(TreeInterface $subBranch): TreeInterface
    {
        $branch = clone $this;

        $branch->branches[] = $subBranch;

        return $branch;
    }

    public function getType(): string
    {
        return 'branch';
    }

    public function getContent(): string
    {
        $content = $this->content . '';

        foreach ($this->branches as $subBranch) {
            $content .= $subBranch->getContent();
        }

        return $content;
    }

    public function getOriginalContent(): string
    {
        $originalContent = '';

        foreach ($this->branches as $subBranch) {
            $originalContent .= $subBranch->getoriginalContent();
        }

        return $originalContent;
    }
}
