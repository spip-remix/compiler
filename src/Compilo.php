<?php

namespace Spip\Component\Compilo;

use Spip\Component\Compilo\Cache\MoteurDeRendu;
use Spip\Component\Compilo\Cache\Transpileur;

class Compilo
{
    private Transpileur $transpiler;

    private MoteurDeRendu $renderer;

    public function __construct()
    {
        $this->transpiler = new Transpileur;
        $this->renderer = new MoteurDeRendu;
    }

    public function render(string $squelette): string
    {
        return $this->renderer->render($this->transpiler->transpile($squelette));
    }
}
