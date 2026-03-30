<?php

declare(strict_types=1);

namespace SpiderWeb\PayumStancer;

use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactory;
use SpiderWeb\PayumStancer\Action\CaptureAction;
use SpiderWeb\PayumStancer\Action\RefundAction;
use SpiderWeb\PayumStancer\Action\StatusAction;

final class StancerGatewayFactory extends GatewayFactory
{
    protected function populateConfig(ArrayObject $config): void
    {
        $config->defaults([
            'payum.factory_name'  => 'stancer',
            'payum.factory_title' => 'Stancer',

            'payum.action.capture' => new CaptureAction(),
            'payum.action.status'  => new StatusAction(),
            'payum.action.refund'  => new RefundAction(),
        ]);

        if (false === (bool) $config['payum.api']) {
            $config['payum.default_options'] = [
                'secret_key' => '',
                'public_key' => '',
            ];
            $config->defaults($config['payum.default_options']);

            $config['payum.required_options'] = ['secret_key', 'public_key'];

            $config['payum.api'] = static function (ArrayObject $config): array {
                $config->validateNotEmpty($config['payum.required_options']);

                return [
                    'secret_key' => $config['secret_key'],
                    'public_key' => $config['public_key'],
                ];
            };
        }
    }
}
