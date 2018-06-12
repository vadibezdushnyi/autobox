<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Config;
use Session;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */

    public function boot(Router $router)
    {
        //

        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */

     public function map(Router $router, Request $request)
     {
         $this->mapWebRoutes($router);

         /** Hidden default locale trick */
         $languages = Config::get('app.locales');
         $locales = array_keys( $languages );
         $fallbackLocale = Config::get('app.fallback_locale');
         $locale = in_array( $request->segment(1), $locales )
           ? $request->segment(1)
           : $fallbackLocale;
         $this->app->setLocale($locale);
         /** Hidden default locale trick */


         $router->group(['namespace' => $this->namespace, 'prefix' => $locale], function($router) {
             require app_path('Http/routes.php');
         });
     }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    protected function mapWebRoutes(Router $router)
    {
        $router->group([
            'namespace' => $this->namespace, 'middleware' => 'web',
        ], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
