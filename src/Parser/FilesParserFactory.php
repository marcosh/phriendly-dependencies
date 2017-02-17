<?php

declare(strict_types = 1);

namespace Marcosh\PhriendlyDependencies\Parser;

use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor;
use PhpParser\ParserFactory;

final class FilesParserFactory
{
    public function createFileParser(NodeVisitor $visitor): FilesParser
    {
        $parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);

        $traverser = new NodeTraverser();
        $traverser->addVisitor($visitor);

        return new FilesParser($parser, $traverser);
    }
}
