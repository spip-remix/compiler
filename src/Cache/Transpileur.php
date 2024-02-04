<?php

namespace Spip\Component\Compilo\Cache;

/**
 * Cache de niveau 1
 * Transpilation d'un squelette en scprit PHP
 * 
 * @author JamesRezo <james@rezo.net>
 */
class Transpileur
{
    public function transpile(string $squelette): string
    {
        $script = 'require_once dirname(__DIR__) . \'/../vendor/autoload.php\';' . \PHP_EOL . \PHP_EOL;
        if (\str_contains($squelette, '#NULL')) {
            $squelette = \str_replace('#NULL', 'echo \'appel de la balise null\';', $squelette);
        }
        $script .= $squelette . \PHP_EOL;

        // echo 'script:"' . $script . '"' . \PHP_EOL;
        return $script;
    }
}
