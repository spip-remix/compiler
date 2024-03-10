<?php

namespace Spip\Component\Compilo\Cache;

use Spip\Component\Compilo\CompilationContext;

/**
 * Cache de niveau 2
 * Évaluation d'un scprit PHP transpilé depuis un squelette SPIP
 * 
 * @author JamesRezo <james@rezo.net>
 */
class MoteurDeRendu
{
    public function render(CompilationContext $context): CompilationContext
    {
        $transpilation = $context->getScript();

        \ob_start();
        eval($transpilation);
        $content = \ob_get_clean();

        // echo 'rendu:"' . $content . '"' . \PHP_EOL;
        $context->withRendu($content);

        return $context;
    }

    public function __invoke($payload)
    {
        return $this->render($payload);
    }
}
