<?php

declare(strict_types = 1);

namespace Marcosh\PhriendlyDependenciesTest\Checker;

use Marcosh\PhriendlyDependencies\Checker\Checker;
use PHPUnit\Framework\TestCase;

final class CheckerTest extends TestCase
{
    /**
     * @var Checker
     */
    private $checker;

    public function setUp()
    {
        $this->checker = new Checker();
    }

    public function testCheckerFiltersOutClassesInNamespace()
    {
        $usedClasses = ['PHPUnit\Framework\TestCase' => 'PHPUnit\Framework\TestCase'];
        $namespaces = ['PHPUnit\\'];

        self::assertEmpty($this->checker->check($usedClasses, $namespaces, []));
    }

    public function testCheckerFiltersOutSystemClasses()
    {
        $usedClasses = ['InvalidArgumentException' => 'InvalidArgumentException'];
        $systemClasses = ['InvalidArgumentException'];

        self::assertEmpty($this->checker->check($usedClasses, [], $systemClasses));
    }

    public function testCheckerDoesNotFilterOutUnfriendlyClasses()
    {
        $usedClasses = [
            'PHPUnit\Framework\TestCase' => 'PHPUnit\Framework\TestCase',
            'InvalidArgumentException' => 'InvalidArgumentException'
        ];

        self::assertSame($usedClasses, $this->checker->check($usedClasses, [], []));
    }
}
