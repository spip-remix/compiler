<?php

use Spip\Component\Compilo\CompilationContext;
use Spip\Component\Compilo\NullTag;

function balise_NULL_dist(CompilationContext $cc)
{
    $balise = new NullTag;

    return (string) $balise;
}
