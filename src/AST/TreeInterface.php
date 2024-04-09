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
interface TreeInterface
{
    /** Expression pour trouver un identifiant de boucle */
    public const NOM_DE_BOUCLE = '[0-9]+|[-_][-_.a-zA-Z0-9]*';

    /** Écriture alambiquée pour rester compatible avec les hexadecimaux des vieux squelettes */
    public const NOM_DE_CHAMP = '#((' . self::NOM_DE_BOUCLE . "):)?(([A-F]*[G-Z_][A-Z_0-9]*)|[A-Z_]+)\b(\*{0,2})";
    /** Balise complète [...(#TOTO) ... ] */
    public const CHAMP_ETENDU = '/\[([^\[]*?)\(' .self:: NOM_DE_CHAMP . '([^)]*\)[^]]*)\]/S';

    /**
     * Undocumented function.
     */
    public function transpile(): TreeInterface;

    /**
     * Undocumented function.
     *
     * @return non-empty-string
     */
    public function getType(): string;

    /**
     * Undocumented function.
     */
    public function getOriginalContent(): string;

    /**
     * Undocumented function.
     */
    public function getContent(): string;
}
