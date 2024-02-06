<?php

namespace Spip\Component\Compilo;

use Spip\Component\Compilo\Cache\MoteurDeRendu;
use Spip\Component\Compilo\Cache\Transpileur;

class Compilo
{
    private Transpileur $transpiler;

    private MoteurDeRendu $renderer;

    private CompilationContext $context;

    public function __construct()
    {
        $this->transpiler = new Transpileur;
        $this->renderer = new MoteurDeRendu;
        $this->context = new CompilationContext;
    }

    public function process(string $squelette): string
    {
        $this->context->withSquelette($squelette);
        $renderer = $this->renderer;
        $transpiler = $this->transpiler;
        $this->context = $renderer($transpiler($this->context));

        return $this->context->getRendu();
    }

    public function getAttributes(): array
    {
        return $this->context->getAttributes();
    }
}
