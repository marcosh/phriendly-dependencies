<?php

declare(strict_types = 1);

namespace Marcosh\PhriendlyDependencies\Parser;

use PhpParser\Error;
use PhpParser\NodeTraverser;
use PhpParser\Parser as PhpParser;

final class FilesParser
{
    /**
     * @var PhpParser
     */
    private $parser;

    /**
     * @var NodeTraverser
     */
    private $traverser;

    public function __construct(PhpParser $parser, NodeTraverser $traverser)
    {
        $this->parser = $parser;
        $this->traverser = $traverser;
    }

    /**
     * parses the files of the iterator and returns an array of used namespaces
     *
     * @param \IteratorIterator $filesIterator
     * @throws Error
     */
    public function parse(\IteratorIterator $filesIterator): void
    {
        foreach ($filesIterator as $file) {
            $this->parseFile($file);
        }
    }

    private function parseFile(\SplFileInfo $file): void
    {
        $source = file_get_contents($file->getRealPath());

        $statements = $this->parser->parse($source);

        $this->traverser->traverse($statements);
    }
}
