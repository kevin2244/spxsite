<?php


declare(strict_types = 1);

namespace App\Model;

use Psr\Container\ContainerInterface;

use GuzzleHttp;

class SPXGuzzleClientFactory
{
    public function __invoke(ContainerInterface $container) : GuzzleHttp\ClientInterface
    {
        $hosts = $container->get('config')['hosts'];
        $guzzleClient = new GuzzleHttp\Client(['base_uri' => $hosts['SPX_URL']]);

        return $guzzleClient;
    }
}