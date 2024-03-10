<?php

namespace Spip\Component\Compilo\Filter\Payload;

/**
 * Undocumented interface.
 * @todo Changer le nom (feature? type?)
 * 
 * @api
 */
interface PayloadInterface
{
    /**
     * Undocumented function.
     *
     * @param mixed $payload
     */
    public function validate($payload): bool;

    public function subType(): string;
}
