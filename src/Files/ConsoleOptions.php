<?php

declare(strict_types = 1);

namespace Marcosh\PhriendlyDependencies\Files;

use InvalidArgumentException;

final class ConsoleOptions
{
    /**
     * @var array
     */
    private $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function path()
    {
        if (isset($this->options['p'])) {
            $path = $this->options['p'];
        } else if (isset($this->options['path'])) {
            $path = $this->options['path'];
        } else {
            throw new InvalidArgumentException('Please provide a path with -p or --path');
        }

        return $path;
    }
}
