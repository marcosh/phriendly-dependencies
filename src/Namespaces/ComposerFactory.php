<?php

declare(strict_types = 1);

namespace Marcosh\PhriendlyDependencies\Namespaces;

use Composer\Factory;
use Composer\IO\ConsoleIO;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

final class ComposerFactory
{
    public function __invoke(): ComposerProxy
    {
        $consoleIo = new ConsoleIO(
            new ArgvInput(),
            new ConsoleOutput(),
            new HelperSet([])
        );
        $composer = Factory::create($consoleIo);

        return new ComposerProxy($composer);
    }
}
