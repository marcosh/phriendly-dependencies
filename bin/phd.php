<?php

declare(strict_types = 1);

use Marcosh\PhriendlyDependencies\Checker\Checker;
use Marcosh\PhriendlyDependencies\Files\ConsoleOptions;
use Marcosh\PhriendlyDependencies\Namespaces\AllowedNamespaces;
use Marcosh\PhriendlyDependencies\Namespaces\ComposerFactory;
use Marcosh\PhriendlyDependencies\Files\PathFiles;
use Marcosh\PhriendlyDependencies\Parser\FilesParserFactory;
use Marcosh\PhriendlyDependencies\Runner\Runner;
use Marcosh\PhriendlyDependencies\Visitor\UseFinderVisitor;

chdir(dirname(__DIR__));

$systemClasses = get_declared_classes();
$systemInterfaces = get_declared_interfaces();
$systemTraits = get_declared_traits();

require __DIR__ . '/../vendor/autoload.php';

$consoleOptions = new ConsoleOptions(getopt('p:', ['path:']));

$runner = new Runner(
    new PathFiles($consoleOptions->path()),
    new UseFinderVisitor(),
    new FilesParserFactory(),
    new AllowedNamespaces((new ComposerFactory())()),
    new Checker(),
    array_merge($systemClasses, $systemInterfaces, $systemTraits)
);

$runner->run();
