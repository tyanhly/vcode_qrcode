<?php

namespace Vcode\Qrcode;

use Illuminate\Support\ServiceProvider;

class QrcodeServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('vcode/qrcode');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Register providers.
        $this->registerQrcode();

        // extend blade engine by adding @qrcode compile function
        $this->app['view.engine.resolver']->resolve('blade')
            ->getCompiler()
            ->extend(function ($view) {
            $html = "<?php Qrcode::render($1); ?>";
            return preg_replace("/@qrcode\((.*)\)/", $html, $view);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array(
            'qrcode'
        );
    }

    /**
     * Register qrcode provider.
     *
     * @return void
     */
    public function registerQrcode()
    {
        // $this->app->bind('Qrcode', function () {
        // return new Qrcode($app);
        // });
        $this->app['qrcode'] = $this->app->share(function ($app) {
            return new Qrcode($app);
        });
    }
}
