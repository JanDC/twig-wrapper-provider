<?php

namespace TwigWrapperProvider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use TwigWrapperProvider\Service\TwigWrapper;

class TwigWrapperProvider implements ServiceProviderInterface
{


    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Application $app A container instance
     */
    public function register(Application $app)
    {
        $app['twigwrapper'] = new TwigWrapper($app);

    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     *
     * @param Application $app
     */
    public function boot(Application $app)
    {
        $app['twigwrapper'] = new TwigWrapper($app);
    }
}