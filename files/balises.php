<?php

use Spip\Component\Compilo\NullBalise;

function balise_NULL_dist()
{
    $balise = new NullBalise;

    return (string) $balise;
}
