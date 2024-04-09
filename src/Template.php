<?php

namespace Spip\Component\Compilo;

use SpipRemix\Component\Compilo\Exception\FileNotFoundException;
use SpipRemix\Component\Compilo\Exception\FileReadException;

class Template
{
    protected function __construct(
        private string $template,
        private string $fromFile = ''
    ) {
    }

    public static function createFromFile(string $filename): self
    {
        if (!file_exists($filename)) {
            throw new FileNotFoundException("Error Processing Request", 1);
        }

        $template = file_get_contents($filename);
        if ($template === false) {
            throw new FileReadException("Error Processing Request", 1);
        }

        return new static($template, $filename);
    }

    public static function createFromString(string $template): self
    {
        return new static($template);
    }

    function render(array $context = []): string
    {
        $content = $this->template;

        foreach($context as $placeholder => $value) {
            $content = str_replace($placeholder, $value, $content);
        }
    
        return $content;
    }    
}
