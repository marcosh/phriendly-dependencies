<?php

declare(strict_types = 1);

namespace Marcosh\PhriendlyDependenciesTest\Files;

use Marcosh\PhriendlyDependencies\Files\PathFiles;
use PHPUnit\Framework\TestCase;

final class PathFilesTest extends TestCase
{
    public function testFiles()
    {
        $pathFiles = new PathFiles(__DIR__);

        $files = [];

        foreach ($pathFiles->files() as $file) {
            $files[] = $file->getFilename();
        }

        $expectedFiles = [
            'ConsoleOptionsTest.php',
            'PathFilesTest.php'
        ];

        self::assertSame($expectedFiles, $files);
    }
}
