<?php

declare(strict_types = 1);

require __DIR__ . '/../vendor/autoload.php';

$parser = (new \PhpParser\ParserFactory())->create(\PhpParser\ParserFactory::PREFER_PHP7);

$source = file_get_contents(__DIR__ . '/../fixtures/Bar.php');

try {
    $statements = $parser->parse($source);
} catch (Exception $e) {
    echo 'Parse error: ' . $e->getMessage();
}

var_dump($statements);

