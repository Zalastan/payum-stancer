<?php

declare(strict_types=1);

namespace SpiderWeb\Sylius\StancerPlugin\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class StancerExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('services.yaml');
        $loader->load('twig_hooks/admin/payment_method/create.yaml');
        $loader->load('twig_hooks/admin/payment_method/update.yaml');
    }

    public function getAlias(): string
    {
        return 'stancer';
    }
}
