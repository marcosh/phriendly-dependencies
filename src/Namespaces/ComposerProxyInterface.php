<?php

declare(strict_types = 1);


namespace Marcosh\PhriendlyDependencies\Namespaces;

use Composer\Package\RootPackageInterface;
use Composer\Repository\WritableRepositoryInterface;

interface ComposerProxyInterface
{
    public function getPackage(): RootPackageInterface;

    public function getLocalRepository(): WritableRepositoryInterface;
}
