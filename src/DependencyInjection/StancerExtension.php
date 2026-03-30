<?php

declare(strict_types=1);

namespace SpiderWeb\Sylius\StancerPlugin\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class StancerExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('services.yaml');
    }

    public function prepend(ContainerBuilder $container): void
    {
        $credentialsTemplate = '@StancerPlugin/admin/payment_method/form/sections/gateway_configuration/credentials.html.twig';

        $container->prependExtensionConfig('sylius_twig_hooks', [
            'hooks' => [
                'sylius_admin.payment_method.create.content.form.sections.gateway_configuration.stancer' => [
                    'credentials' => ['template' => $credentialsTemplate, 'priority' => 100],
                ],
                'sylius_admin.payment_method.update.content.form.sections.gateway_configuration.stancer' => [
                    'credentials' => ['template' => $credentialsTemplate, 'priority' => 100],
                ],
            ],
        ]);
    }

    public function getAlias(): string
    {
        return 'stancer';
    }
}
