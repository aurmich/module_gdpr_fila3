<?php

declare(strict_types=1);

namespace Modules\Gdpr\Providers;

use Illuminate\Routing\Router;
use Modules\Gdpr\Datas\GdprData;
<<<<<<< HEAD
use Modules\Xot\Actions\Module\GetModulePathByGeneratorAction;
use Modules\Xot\Providers\XotBaseServiceProvider;
=======
use Modules\Xot\Providers\XotBaseServiceProvider;
use Modules\Xot\Actions\Module\GetModulePathByGeneratorAction;
>>>>>>> 6d1fb23 (.)

class GdprServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Gdpr';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;

<<<<<<< HEAD
    #[\Override]
=======
>>>>>>> 6d1fb23 (.)
    public function boot(): void
    {
        parent::boot();

        $lang_path = app(GetModulePathByGeneratorAction::class)->execute($this->name, 'lang');
        $this->loadTranslationsFrom($lang_path, 'cookie-consent');
<<<<<<< HEAD

=======
        
>>>>>>> 6d1fb23 (.)
        $router = app('router');
        $this->registerMyMiddleware($router);
    }

    public function registerMyMiddleware(Router $router): void
    {
<<<<<<< HEAD
        $gdpr = GdprData::make();
        if ($gdpr->cookie_banner_enabled) {
=======
        $gdpr=GdprData::make();
        if($gdpr->cookie_banner_enabled){
>>>>>>> 6d1fb23 (.)
            $router->pushMiddlewareToGroup('web', \Statikbe\CookieConsent\CookieConsentMiddleware::class);
        }
    }

<<<<<<< HEAD
    
=======
    public function register(): void
    {
        parent::register();
    }
>>>>>>> 6d1fb23 (.)
}
