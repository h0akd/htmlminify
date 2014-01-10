<?php

namespace H0akd\Htmlminify;

use Illuminate\Support\ServiceProvider;
use H0akd\Htmlminify\HtmlMinifyCompiler;
use Illuminate\View\Engines\CompilerEngine;


class HtmlminifyServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $app = $this->app;
        $app->view->getEngineResolver()->register('blade.php', function () use ($app) {
            $cachePath = storage_path() . '/views';
            $compiler = new HtmlMinifyCompiler($app['files'], $cachePath);
            return new CompilerEngine($compiler);
        });
        $app->view->addExtension('blade.php', 'blade.php');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array();
    }

}
