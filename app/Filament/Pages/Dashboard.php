<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
<<<<<<< HEAD
<<<<<<< HEAD
use Modules\Xot\Filament\Pages\XotBaseDashboard;

class Dashboard extends XotBaseDashboard
=======

class Dashboard extends BaseDashboard
>>>>>>> 7b6074d (.)
=======
use Modules\Xot\Filament\Pages\XotBaseDashboard;

class Dashboard extends XotBaseDashboard
>>>>>>> 1e9c33c (.)
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    // protected static string $view = 'gdpr::filament.pages.dashboard';
}
