<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\PHPUnit\Set\PHPUnitLevelSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use RectorLaravel\Rector\MethodCall\RedirectRouteToToRouteHelperRector;
use RectorLaravel\Set\LaravelSetList;

return static function (RectorConfig $rectorConfig): void {
<<<<<<< HEAD
    $rectorConfig->paths([
        __DIR__,
    ]);

    $rectorConfig->skip([
        './vendor/',
        '*/docs',
        '*/vendor',
    ]);
=======
    $rectorConfig->paths(
        [
            __DIR__,
        ]
    );

    $rectorConfig->skip(
        [
            './vendor/',
            '*/docs',
            '*/vendor',
        ]
    );
>>>>>>> 6d1fb23 (.)

    // register a single rule
    // $rectorConfig->rule(InlineConstructorDefaultToPropertyRector::class);
    // $rectorConfig->rule(RedirectRouteToToRouteHelperRector::class);

    // define sets of rules
<<<<<<< HEAD
    $rectorConfig->sets([
        PHPUnitLevelSetList::UP_TO_PHPUNIT_100,
        // SetList::DEAD_CODE,
        // SetList::CODE_QUALITY,
        LevelSetList::UP_TO_PHP_81,
        LaravelSetList::LARAVEL_100,
        // SetList::NAMING, //problemi con injuction
        SetList::TYPE_DECLARATION,
        // SetList::CODING_STYLE,
        // SetList::PRIVATIZATION,//problemi con final
        // SetList::EARLY_RETURN,
        // SetList::INSTANCEOF,
    ]);
=======
    $rectorConfig->sets(
        [
            PHPUnitLevelSetList::UP_TO_PHPUNIT_100,
            // SetList::DEAD_CODE,
            // SetList::CODE_QUALITY,
            LevelSetList::UP_TO_PHP_81,
            LaravelSetList::LARAVEL_100,

            // SetList::NAMING, //problemi con injuction
            SetList::TYPE_DECLARATION,
            // SetList::CODING_STYLE,
            // SetList::PRIVATIZATION,//problemi con final
            // SetList::EARLY_RETURN,
            // SetList::INSTANCEOF,
        ]
    );
>>>>>>> 6d1fb23 (.)

    $rectorConfig->importNames();
};
