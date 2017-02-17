<?php

declare(strict_types = 1);

namespace Marcosh\PhriendlyDependenciesTest\Parser;

use Marcosh\PhriendlyDependencies\Parser\FilesParser;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\ParserFactory;
use PHPUnit\Framework\TestCase;

final class FileParserTest extends TestCase
{
    public function testParse()
    {
        $visitor = new class extends NodeVisitorAbstract {
            /* @var string[] */
            private $nodes;

            public function enterNode(Node $node): void
            {
                $this->nodes[] = $node->getType();
            }

            public function nodes(): array
            {
                return $this->nodes;
            }
        };

        $traverser = new NodeTraverser();
        $traverser->addVisitor($visitor);

        $parser = new FilesParser(
            (new ParserFactory())->create(ParserFactory::PREFER_PHP7),
            $traverser
        );

        $directoryIterator = new \DirectoryIterator(__DIR__);
        $iterator = new \RegexIterator($directoryIterator, '/^ParserFixture\.php$/');

        $parser->parse($iterator);

        $expected = [
            'Stmt_Declare',
            'Stmt_DeclareDeclare',
            'Scalar_LNumber',
            'Stmt_Namespace',
            'Name',
            'Stmt_Class',
            'Stmt_Property',
            'Stmt_PropertyProperty',
            'Stmt_ClassMethod',
            'Stmt_Return',
            'Expr_PropertyFetch',
            'Expr_Variable'
        ];

        self::assertSame($expected, $visitor->nodes());
    }
}
