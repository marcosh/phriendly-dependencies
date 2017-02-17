<?php

declare(strict_types = 1);

namespace Marcosh\PhriendlyDependencies\Namespaces;

use Composer\Package\Link;
use Composer\Package\PackageInterface;

final class AllowedNamespaces
{
    /**
     * @var ComposerProxyInterface
     */
    private $composer;

    public function __construct(ComposerProxyInterface $composer)
    {
        $this->composer = $composer;
    }

    public function retrieveAllowedNamespaces(): array
    {
        return call_user_func_array(
            'array_merge',
            array_map(function (PackageInterface $package) {
                return array_reduce($package->getAutoload(), function ($namespaces, $type) {
                    return array_merge($namespaces, array_keys($type));
                }, []);
            }, $this->allowedPackages())
        );
    }

    /**
     * @return PackageInterface[]
     */
    private function allowedPackages(): array
    {
        $package = $this->composer->getPackage();

        $localRepository = $this->composer->getLocalRepository();

        $firstDependencies = array_filter(array_map(function (Link $link) use ($localRepository) {
            return $localRepository->findPackage($link->getTarget(), $link->getConstraint());
        }, $package->getRequires()));

        return array_merge([$package], $firstDependencies);
    }
}
