<?php

namespace Vcode\Qrcode;

use Illuminate\Support\ServiceProvider;

/**
 * Service Provider for laravel
 * @author Tung Ly
 */
class QrcodeServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     * @author Tung Ly
     */
    public function boot()
    {
        $this->package('vcode/qrcode');
    }

    /**
     * Register the service provider.
     *
     * @return void
     * @author Tung Ly
     */
    public function register()
    {
        // Register providers.
        $this->registerQrcode();
        $this->registerBladeFunctions();

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     * @author Tung Ly
     */
    public function provides()
    {
        return array(
            'qrcode'
        );
    }

    /**
     * @return mixed
     * @author Tung Ly
     */
    public function registerBladeFunctions(){

        // extend blade engine by adding @qrcode compile function
        $this->app['view.engine.resolver']->resolve('blade')
        ->getCompiler()
        ->extend(function ($view) {
            $html = "<?php Qrcode::render($1); ?>";
            return preg_replace("/@qrcode\((.*)\)/", $html, $view);
        });

        // extend blade engine by adding @qrcodeBase64 compile function
        $this->app['view.engine.resolver']->resolve('blade')
        ->getCompiler()
        ->extend(function ($view) {
            $html = "<?php Qrcode::renderBase64($1); ?>";
            return preg_replace("/@qrcodeBase64\((.*)\)/", $html, $view);
        });

        // extend blade engine by adding @qrcodeBase64Dom compile function
        $this->app['view.engine.resolver']->resolve('blade')
        ->getCompiler()
        ->extend(function ($view) {
            $html = "<?php Qrcode::renderBase64Dom($1); ?>";
            return preg_replace("/@qrcodeBase64Dom\((.*)\)/", $html, $view);
        });
    }

    /**
     * Register qrcode provider.
     * @author Tung Ly
     */
    public function registerQrcode()
    {
        $this->app['qrcode'] = $this->app->share(function ($app) {
            $config = $app['config'];
            return new Qrcode($config);
        });
    }
}
