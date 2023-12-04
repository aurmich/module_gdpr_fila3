<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Str;

class MainDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'xot::filament.pages.dashboard';

    /*
    public function __construct(){
        dddx('a'); //1
    }
    */

    public function mount()
    {
        $user = auth()->user();
        $modules = $user->roles->filter(function ($item) {
            return Str::endsWith($item->name, '::admin');
        });

        if (1 == $modules->count()) {
            $panel_name = $modules->first()->name;
            $module_name = Str::before($panel_name, '::admin');
            $url = '/'.$module_name.'/admin/dashboard';
            redirect($url);
        }

        /*
        if (! $user?->hasRole('super-admin')) {
            redirect('/admin');
        }
        */
    }
}
