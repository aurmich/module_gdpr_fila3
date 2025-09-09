<?php

declare(strict_types=1);

namespace Modules\Gdpr\Providers;

use Illuminate\Routing\Router;
<<<<<<< HEAD
=======
use Modules\Gdpr\Datas\GdprData;
>>>>>>> 6a853ea (.)
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
        $router->pushMiddlewareToGroup('web', \Statikbe\CookieConsent\CookieConsentMiddleware::class);
=======
        $gdpr=GdprData::make();
        if($gdpr->cookie_banner_enabled){
            $router->pushMiddlewareToGroup('web', \Statikbe\CookieConsent\CookieConsentMiddleware::class);
        }
>>>>>>> 6a853ea (.)
    }

    public function register(): void
    {
        parent::register();
    }
}
