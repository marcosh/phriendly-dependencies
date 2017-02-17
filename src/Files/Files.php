<?php

declare(strict_types = 1);

namespace Marcosh\PhriendlyDependencies\Files;

interface Files
{
    public function files(): \IteratorIterator;
}
