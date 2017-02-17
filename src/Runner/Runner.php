<?php

declare(strict_types = 1);

namespace Marcosh\PhriendlyDependencies\Runner;

use InvalidArgumentException;
use Marcosh\PhriendlyDependencies\Checker\Checker;
use Marcosh\PhriendlyDependencies\Files\Files;
use Marcosh\PhriendlyDependencies\Namespaces\AllowedNamespaces;
use Marcosh\PhriendlyDependencies\Parser\FilesParserFactory;
use Marcosh\PhriendlyDependencies\Visitor\UseFinderVisitor;
use PhpParser\Error;
use PhpParser\NodeVisitor;

final class Runner
{
    /**
     * @var Files
     */
    private $files;

    /**
     * @var UseFinderVisitor
     */
    private $visitor;

    /**
     * @var FilesParserFactory
     */
    private $parserFactory;

    /**
     * @var AllowedNamespaces
     */
    private $allowedNamespaces;

    /**
     * @var Checker
     */
    private $checker;

    /**
     * @var array
     */
    private $systemClasses;

    public function __construct(
        Files $files,
        NodeVisitor $visitor,
        FilesParserFactory $parserFactory,
        AllowedNamespaces $allowedNamespaces,
        Checker $checker,
        array $systemClasses
    ) {
        $this->files = $files;
        $this->visitor = $visitor;
        $this->parserFactory = $parserFactory;
        $this->allowedNamespaces = $allowedNamespaces;
        $this->checker = $checker;
        $this->systemClasses = $systemClasses;
    }

    public function run ()
    {
        /* RETRIEVE FILES TO PARSE */

        try {
            $files = $this->files->files();
        } catch (InvalidArgumentException $exception) {
            echo 'Error while retrieving files: ' . $exception->getMessage() . PHP_EOL;
            exit;
        }

        /* PARSE */

        $parser = $this->parserFactory->createFileParser($this->visitor);

        try {
            $parser->parse($files);
        } catch (Error $error) {
            echo 'Parse error: ' . $error->getMessage() . PHP_EOL;
            exit;
        }

        /* RETRIEVE ALLOWED NAMESPACES */

        $namespaces = $this->allowedNamespaces->retrieveAllowedNamespaces();

        /* CHECK FOR NOT ALLOWED NAMESPACES USAGE */

        $unfriendlyUsages = $this->checker->check(
            $this->visitor->usedClasses(),
            $namespaces,
            $this->systemClasses
        );

        foreach ($unfriendlyUsages as $usedClass)
        {
            echo "Class {$usedClass} is not global or from a friendly namespace\n";
        }
    }
}
