<?php

namespace Spip\Component\Compilo\Cache;

use Spip\Component\Compilo\AST\Branch;
use Spip\Component\Compilo\CompilationContext;

/**
 * Cache de niveau 1
 * Transpilation d'un squelette en scprit PHP
 *
 * Détecter dans une chaine de caractères:
 * - le texte qui doit être restituer en l'état (contenu brut, hors contexte de boucle ou de balise)
 * - les balises SPIP `[avant(#BALISE|filtre{}|...)après]`
 * - les boucles SPIP ```spip
 * <BBid>
 *  tout le temps, une fois, avant
 * <Bid>
 *  une fois avant si non-vide
 * <BOUCLEid(OBJET_SPIP){critere}>
 *  à chaque fois (ou vide)
 * </BOUCLEid>
 *  une fois après si non-vide
 * </Bid>
 *  alternatif si vide
 * <//Bid>
 *  tout le temps, une fois, après
 * <//BBid>
 * ```
 * - les inclusions dynamique SPIP `<INCLURE(SQUELETTE)>`
 * Fabriquer l'AST correspondant
 * Générer le script PHP déduit de l'AST et le renvoyer
 *
 * @author JamesRezo <james@rezo.net>
 */
class Transpileur
{
    public function transpile(CompilationContext $context): CompilationContext
    {
        $squelette = $context->getSquelette();
        $script = 'require_once dirname(__DIR__) . \'/../vendor/autoload.php\';' . \PHP_EOL . \PHP_EOL;

        // Faire l'AST du squelette
        $parser = new Parser($squelette);
        $tree = $parser->getTree()->transpile()->getContent();

        $script .= $tree . \PHP_EOL;

        $context->withScript($script);
        $attributes = $context->getAttributes();
        $attributes['mdscript'] = md5($script);
        $context->withAttributes($attributes);

        return $context;
    }

    public function __invoke($payload)
    {
        return $this->transpile($payload);
    }
}
