<?php

namespace Spip\Component\Compilo;

/**
 * Payload du compilateur.
 * 
 * @author JamesRezo <james@rezo.net>
 */
class CompilationContext
{
    private ?string $page = null;

    private ?string $squelette = null;

    private ?string $script = null;

    private ?string $rendu = null;

    private array $attributes = [];

    public function getPage(): string
    {
        return $this->page;
    }

    public function withPage(string $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getSquelette(): string
    {
        return $this->squelette;
    }

    public function withSquelette(string $squelette): self
    {
        $this->squelette = $squelette;

        return $this;
    }

    public function getScript(): string
    {
        return $this->script;
    }

    public function withScript(string $script): self
    {
        $this->script = $script;

        return $this;
    }

    public function getRendu(): string
    {
        return $this->rendu;
    }

    public function withRendu(string $rendu): self
    {
        $this->rendu = $rendu;

        return $this;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function withAttributes(array $attributes): self
    {
        $this->attributes = $attributes;

        return $this;
    }
}
