<?php
/*
 *  package: Custom Fields - Youtube plugin - FREE Version
 *  copyright: Copyright (c) 2026. Jeroen Moolenschot | Joomill
 *  license: GNU General Public License version 3 or later
 *  link: https://www.joomill-extensions.com
 */

\defined('_JEXEC') or die;

use Joomill\Plugin\Fields\Youtube\Extension\Youtube;
use Joomla\CMS\Extension\PluginInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\Event\DispatcherInterface;

return new class () implements ServiceProviderInterface {
    /**
     * Registers the service provider with a DI container.
     *
     * @param   Container  $container  The DI container.
     *
     * @return  void
     *
     * @since   4.3.0
     */
    public function register(Container $container): void
    {
        $factory = function (Container $container): PluginInterface {
            $subject = $container->get(DispatcherInterface::class);
            $plugin  = new Youtube(
                $subject,
                (array) PluginHelper::getPlugin('fields', 'youtube')
            );
            $plugin->setApplication(Factory::getApplication());

            return $plugin;
        };

        // Lazy plugin loading exists from Joomla 6.1 (joomla/di 3.1.0) and builds the
        // plugin on demand when its event is dispatched (PHP >= 8.4 lazy proxy). On
        // Joomla 5.x / 6.0 the method is absent, so fall back to the plain factory.
        $container->set(
            PluginInterface::class,
            method_exists($container, 'lazy')
                ? $container->lazy(Youtube::class, $factory)
                : $factory
        );
    }
};
