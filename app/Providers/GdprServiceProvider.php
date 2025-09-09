<?php

declare(strict_types=1);

namespace Modules\Gdpr\Providers;

use Illuminate\Routing\Router;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
use Modules\Gdpr\Datas\GdprData;
>>>>>>> 6a853ea (.)
=======
use Modules\Gdpr\Datas\GdprData;
>>>>>>> 6d1fb23 (.)
=======
>>>>>>> e55f1ad (.)
use Modules\Xot\Providers\XotBaseServiceProvider;
use Modules\Xot\Actions\Module\GetModulePathByGeneratorAction;

class GdprServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Gdpr';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;

    public function boot(): void
    {
        parent::boot();

        $lang_path = app(GetModulePathByGeneratorAction::class)->execute($this->name, 'lang');
        $this->loadTranslationsFrom($lang_path, 'cookie-consent');
        
        $router = app('router');
        $this->registerMyMiddleware($router);
    }

    public function registerMyMiddleware(Router $router): void
    {
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
        $router->pushMiddlewareToGroup('web', \Statikbe\CookieConsent\CookieConsentMiddleware::class);
=======
=======
>>>>>>> 6d1fb23 (.)
        $gdpr=GdprData::make();
        if($gdpr->cookie_banner_enabled){
            $router->pushMiddlewareToGroup('web', \Statikbe\CookieConsent\CookieConsentMiddleware::class);
        }
<<<<<<< HEAD
>>>>>>> 6a853ea (.)
=======
>>>>>>> 6d1fb23 (.)
=======
        $router->pushMiddlewareToGroup('web', \Statikbe\CookieConsent\CookieConsentMiddleware::class);
>>>>>>> e55f1ad (.)
    }

    public function register(): void
    {
        parent::register();
    }
}
