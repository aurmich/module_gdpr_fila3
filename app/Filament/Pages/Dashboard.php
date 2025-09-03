<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
<<<<<<< HEAD
use Modules\Xot\Filament\Pages\XotBaseDashboard;

class Dashboard extends XotBaseDashboard
=======

class Dashboard extends BaseDashboard
>>>>>>> 7b6074d (.)
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    // protected static string $view = 'gdpr::filament.pages.dashboard';
}
