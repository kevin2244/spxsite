<?php

namespace App\viewhelpers;

use function array_flip;
use function array_key_exists;
use function json_decode;
use Zend\View\Helper\AbstractHelper;
use GuzzleHttp\Client;//todo get this as a service

class MarqueList extends AbstractHelper
{
    private $hosts;
    private $validmarques;
    private $serverUrl;
    private $urlhelper;

    public function __construct($hosts, $marques, $serverUrl, $url) {
        $this->hosts = $hosts;
        $this->validmarques = $marques;
        $this->serverUrl = $serverUrl;
        $this->urlhelper = $url;
    }

    public function __invoke()
    {
        $lookupmarques = array_flip($this->validmarques);
        $menu = '';
        $spxUrl = $this->hosts['SPX_URL'];
        $client = new Client(['base_uri' => $spxUrl]);
        $response = $client->request('GET', 'marquelist');
        $marqueListData = json_decode($response->getBody(), true);

        foreach($marqueListData as $marque => $data) {

            if (!array_key_exists($marque, $lookupmarques)) {continue;}

            $marquelinkname =  $lookupmarques[$marque];
            $marque = htmlspecialchars($marque, ENT_QUOTES, 'UTF-8');
            $helper = $this->serverUrl;
            $urlhelper = $this->urlhelper;
            $href = $helper($urlhelper('carmarques', ['marque' => $marquelinkname]));
            $menu .= <<<EOF
            <a class="dropdown-item" href="$href">$marque</a>
EOF;
        }
        return $menu;
    }
}