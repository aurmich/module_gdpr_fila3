<?php

declare(strict_types=1);

namespace Modules\Gdpr\Providers;

use Illuminate\Routing\Router;
use Modules\Xot\Providers\XotBaseServiceProvider;
<<<<<<< HEAD
use Modules\Xot\Actions\Module\GetModulePathByGeneratorAction;
=======
>>>>>>> 3d68afd (.)

class GdprServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Gdpr';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    public function boot(): void
    {
        parent::boot();

<<<<<<< HEAD
        $lang_path = app(GetModulePathByGeneratorAction::class)->execute($this->name, 'lang');
        $this->loadTranslationsFrom($lang_path, 'cookie-consent');
        
        $router = app('router');
=======
        $relativePath = config('modules.paths.generator.lang.path');
        $lang_path = module_path($this->name, $relativePath);

        $this->loadTranslationsFrom($lang_path, 'cookie-consent');
        $router = app('router');

        // $this->app['router']->pushMiddlewareToGroup('web', \Statikbe\CookieConsent\CookieConsentMiddleware::class);
>>>>>>> 3d68afd (.)
        $this->registerMyMiddleware($router);
    }

    public function registerMyMiddleware(Router $router): void
    {
        $router->pushMiddlewareToGroup('web', \Statikbe\CookieConsent\CookieConsentMiddleware::class);
    }

    public function register(): void
    {
        parent::register();
    }
}
