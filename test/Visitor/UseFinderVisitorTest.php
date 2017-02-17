<?php

declare(strict_types = 1);

namespace Marcosh\PhriendlyDependenciesTest\Visitor;

use Marcosh\PhriendlyDependencies\Visitor\UseFinderVisitor;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\GroupUse;
use PhpParser\Node\Stmt\Use_;
use PhpParser\Node\Stmt\UseUse;
use PHPUnit\Framework\TestCase;

final class UseFinderVisitorTest extends TestCase
{
    /**
     * @var UseFinderVisitor
     */
    private $useFinderVisitor;

    public function setUp()
    {
        $this->useFinderVisitor = new UseFinderVisitor();
    }

    public function testNoUsedClassesIfNoUseNodesLeft()
    {
        $this->useFinderVisitor->leaveNode(new Name('name'));

        self::assertSame([], $this->useFinderVisitor->usedClasses());
    }

    public function testUsedClassRecordedOnUseNode()
    {
        $uses = new Use_([
            new UseUse(new Name('MyClass')),
            new UseUse(new Name(['MyNamespace', 'MyClass']))
        ]);

        $this->useFinderVisitor->leaveNode($uses);

        $expected = [
            'MyClass' => 'MyClass',
            'MyNamespace\MyClass' => 'MyNamespace\MyClass'
        ];

        self::assertSame($expected, $this->useFinderVisitor->usedClasses());
    }

    public function testUsedClassRecordedOnGroupUseNode()
    {
        $uses = new GroupUse(
            new Name('MyPrefix'),
            [
                new UseUse(new Name('MyClass')),
                new UseUse(new Name(['MyNamespace', 'MyClass']))
            ]
        );

        $this->useFinderVisitor->leaveNode($uses);

        $expected = [
            'MyPrefix\MyClass' => 'MyPrefix\MyClass',
            'MyPrefix\MyNamespace\MyClass' => 'MyPrefix\MyNamespace\MyClass'
        ];

        self::assertSame($expected, $this->useFinderVisitor->usedClasses());
    }
}
