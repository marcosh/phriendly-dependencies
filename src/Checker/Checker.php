<?php

declare(strict_types = 1);

namespace Marcosh\PhriendlyDependencies\Checker;

final class Checker
{
    public function check(array $usedClasses, array $namespaces, array $systemClasses): array
    {
        return array_filter($usedClasses, function ($usedClass) use ($namespaces, $systemClasses) {
            $usedInNamespaces = array_reduce($namespaces, function (bool $alreadyUsed, string $namespace) use ($usedClass) {
                return $alreadyUsed || strpos($usedClass, $namespace) === 0;
            }, false);

            return !$usedInNamespaces && !in_array($usedClass, $systemClasses, true);
        });
    }
}
