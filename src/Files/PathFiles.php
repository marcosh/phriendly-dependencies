<?php

declare(strict_types = 1);

namespace Marcosh\PhriendlyDependencies\Files;

use IteratorIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

final class PathFiles implements Files
{
    /**
     * @var string
     */
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function files(): IteratorIterator
    {
        $directoryIterator = new RecursiveDirectoryIterator($this->path);
        $recursiveIterator = new RecursiveIteratorIterator($directoryIterator);
        return new RegexIterator($recursiveIterator, '/^.+\.php$/i');
    }
}
