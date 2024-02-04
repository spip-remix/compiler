<?php

namespace Spip\Component\Compilo\Cache;

/**
 * Cache de niveau 2
 * Évaluation d'un scprit PHP transpilé depuis un squelette SPIP
 * 
 * @author JamesRezo <james@rezo.net>
 */
class MoteurDeRendu
{
    public function render(string $transpilation): string
    {
        \ob_start();
        eval($transpilation);
        $content = \ob_get_clean();

        // echo 'rendu:"' . $content . '"' . \PHP_EOL;
        return $content;
    }
}
