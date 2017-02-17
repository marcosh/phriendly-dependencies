<?php

declare(strict_types = 1);

namespace Marcosh\PhriendlyDependenciesTest\Namespaces;

use Composer\Package\Link;
use Composer\Package\Package;
use Composer\Package\RootPackage;
use Composer\Package\RootPackageInterface;
use Composer\Repository\WritableArrayRepository;
use Composer\Repository\WritableRepositoryInterface;
use Composer\Semver\Constraint\EmptyConstraint;
use Marcosh\PhriendlyDependencies\Namespaces\AllowedNamespaces;
use Marcosh\PhriendlyDependencies\Namespaces\ComposerProxyInterface;
use PHPUnit\Framework\TestCase;

final class AllowedNamespacesTest extends TestCase
{
    public function testRetrieveAllowedNamespaces()
    {
        $composerProxy = new class implements ComposerProxyInterface {
            public function getPackage(): RootPackageInterface
            {
                $rootPackage = new RootPackage('my-package', '1.0.0', '1.0.0');

                $rootPackage->setRequires([
                    new Link(
                        'marcosh/phriendly-dependencies',
                        'composer/composer',
                        new EmptyConstraint()
                    )
                ]);

                $rootPackage->setAutoload([
                    'psr-4' => [
                        'Marcosh\\PhriendlyDependencies\\' => 'src/'
                    ]
                ]);

                return $rootPackage;
            }

            public function getLocalRepository(): WritableRepositoryInterface
            {
                $package = new Package('composer/composer', '1.0.0', '1.0.0');

                $package->setAutoload([
                    'psr-4' => [
                        'Composer\\Composer\\' => 'src/'
                    ]
                ]);

                return new WritableArrayRepository([$package]);
            }
        };

        $expectedNamespaces = [
            'Marcosh\\PhriendlyDependencies\\',
            'Composer\\Composer\\'
        ];

        self::assertSame(
            $expectedNamespaces,
            (new AllowedNamespaces($composerProxy))->retrieveAllowedNamespaces()
        );
    }
}
