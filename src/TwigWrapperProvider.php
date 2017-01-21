<?php

namespace TwigWrapperProvider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use TwigWrapper\TwigWrapper;

class TwigWrapperProvider implements ServiceProviderInterface
{
    /** @var string */
    private $twigIdentifier;

    /** @var array */
    private $postProcessors;

    public function __construct($twigIdentifier = 'twig', array $postProcessors = [])
    {
        $this->twigIdentifier = $twigIdentifier;
        $this->postProcessors = $postProcessors;
    }


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
        // Nothing to do here
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
        $app['twigwrapper'] = new TwigWrapper($app[$this->twigIdentifier], $this->postProcessors);
    }
}