<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Symfony\Set\SymfonySetList;

return static function (RectorConfig $rectorConfig): void {
    // Set the paths to your source code
    $rectorConfig->paths([__DIR__ . '/src']);

    // Import the Symfony 6.4 set list for automatic refactoring
    $rectorConfig->import(SymfonySetList::SYMFONY_64);
};
