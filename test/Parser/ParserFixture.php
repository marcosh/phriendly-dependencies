<?php

declare(strict_types = 1);

namespace Marcosh\PhriendlyDependenciesTest\Parser;

final class ParserFixture
{
    private $privateVariable;

    public function variable()
    {
        return $this->privateVariable;
    }
}

