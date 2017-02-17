<?php

declare(strict_types = 1);

namespace Marcosh\PhriendlyDependenciesTest\Files;

use Marcosh\PhriendlyDependencies\Files\ConsoleOptions;
use PHPUnit\Framework\TestCase;

final class ConsoleOptionsTest extends TestCase
{
    public function testPathWithPOption()
    {
        $consoleOptions = new ConsoleOptions(['p' => 'path']);

        self::assertSame('path', $consoleOptions->path());
    }

    public function testPathWithPathOption()
    {
        $consoleOptions = new ConsoleOptions(['path' => 'path']);

        self::assertSame('path', $consoleOptions->path());
    }

    public function testPathWithoutOptions()
    {
        self::expectException(\InvalidArgumentException::class);

        $consoleOptions = new ConsoleOptions([]);

        $consoleOptions->path();
    }
}
