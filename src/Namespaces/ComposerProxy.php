<?php

declare(strict_types = 1);

namespace Marcosh\PhriendlyDependencies\Namespaces;

use Composer\Composer;
use Composer\Package\RootPackageInterface;
use Composer\Repository\WritableRepositoryInterface;

final class ComposerProxy implements ComposerProxyInterface
{
    /**
     * @var Composer
     */
    private $composer;

    public function __construct(Composer $composer)
    {
        $this->composer = $composer;
    }

    public function getPackage(): RootPackageInterface
    {
        return $this->composer->getPackage();
    }

    public function getLocalRepository(): WritableRepositoryInterface
    {
        return $this->composer->getRepositoryManager()->getLocalRepository();
    }
}
