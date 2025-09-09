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
>>>>>>> 618564f (.)

class GdprServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Gdpr';
<<<<<<< HEAD

    protected string $module_dir = __DIR__;

=======
    protected string $module_dir = __DIR__;
>>>>>>> 618564f (.)
    protected string $module_ns = __NAMESPACE__;

    public function boot(): void
    {
        parent::boot();

        $lang_path = app(GetModulePathByGeneratorAction::class)->execute($this->name, 'lang');
        $this->loadTranslationsFrom($lang_path, 'cookie-consent');
<<<<<<< HEAD

=======
        
>>>>>>> 618564f (.)
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
>>>>>>> 618564f (.)
            $router->pushMiddlewareToGroup('web', \Statikbe\CookieConsent\CookieConsentMiddleware::class);
        }
    }

    public function register(): void
    {
        parent::register();
    }
}
