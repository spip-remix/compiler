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
    private array $metaDonnees = [];

    public function render(string $transpilation): string
    {
        $this->metaDonnees['script'] = md5($transpilation);

        \ob_start();
        eval($transpilation);
        $content = \ob_get_clean();

        // echo 'rendu:"' . $content . '"' . \PHP_EOL;
        return $content;
    }

    public function getMetaDonnees(): array
    {
        return $this->metaDonnees;
    }
}
