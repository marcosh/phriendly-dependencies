<?php

declare(strict_types = 1);

namespace Marcosh\PhriendlyDependencies\Visitor;

use PhpParser\Node;
use PhpParser\Node\Stmt\GroupUse;
use PhpParser\Node\Stmt\Use_;
use PhpParser\NodeVisitorAbstract;

final class UseFinderVisitor extends NodeVisitorAbstract
{
    /**
     * @var array
     */
    private $usedClasses = [];

    public function leaveNode(Node $node): void
    {
        if ($node instanceof Use_) {
            foreach ($node->uses as $use) {
                $this->usedClasses[(string) $use->name] = (string) $use->name;
            }
        }

        if ($node instanceof GroupUse) {
            foreach ($node->uses as $use) {
                $this->usedClasses[$node->prefix . '\\' . $use->name] = $node->prefix . '\\' . $use->name;
            }
        }
    }

    public function usedClasses(): array
    {
        return $this->usedClasses;
    }
}
