<?php

namespace Nanbando\Bundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class NanbandoExtension extends Extension
{
    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('nanbando.name', $config['name']);
        $container->setParameter('nanbando.temp', $config['temp']);
        $container->setParameter('nanbando.backup', $config['backup']);
        $container->setParameter('nanbando.storage.locale_directory', $config['storage']['local_directory']);
        $container->setParameter('nanbando.storage.remote_service', $config['storage']['remote_service']);

        $container->prependExtensionConfig(
            'oneup_flysystem',
            [
                'adapters' => [
                    'local' => ['local' => ['directory' => $config['storage']['local_directory']]],
                ],
                'filesystems' => [
                    'local' => [
                        'adapter' => 'local',
                        'alias' => 'filesystem.local',
                        'plugins' => ['filesystem.list_files'],
                    ],
                ],
            ]
        );

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
    }
}
