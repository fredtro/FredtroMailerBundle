<?php

namespace Fredtro\MailerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Fredtro\MailerBundle\Model\Mailer\Config;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class FredtroMailerExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $from = empty($config['from']['name']) ? array($config['from']['address']) :
            array($config['from']['address'] => $config['from']['name']);

        //build config and set as argument form mailer
        $configDef = new Definition(Config::class, [$from]);
        $container
            ->getDefinition('fredtro.mailer')
            ->addArgument($configDef);
    }
}
