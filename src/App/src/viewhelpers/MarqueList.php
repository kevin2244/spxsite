<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);

namespace App\viewhelpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Zend\View\Helper\AbstractHelper;

//todo get this as a service

class MarqueList extends AbstractHelper
{
    private $hosts;
    private $validmarques;
    private $serverUrl;
    private $urlhelper;

    public function __construct($hosts, $marques, $serverUrl, $url)
    {
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

        try {
            $response = $client->request('GET', "marquelist");
        } catch (GuzzleException $e) {
            $noresponse = true;
        }

        if (empty($noresponse) && isset($response)) {
            $marqueListData = json_decode($response->getBody()->getContents(), true);
            foreach ($marqueListData as $marque => $data) {
                if (!array_key_exists($marque, $lookupmarques)) {
                    continue;
                }
                $marquelinkname = $lookupmarques[$marque];
                $marque = htmlspecialchars($marque, ENT_QUOTES, 'UTF-8');
                $helper = $this->serverUrl;
                $urlhelper = $this->urlhelper;
                $href = $helper(
                    $urlhelper('carmarques', ['marque' => $marquelinkname])
                );
                $menu
                    .= <<<EOF
            <a class="dropdown-item" href="$href">$marque</a>
EOF;
            }
        }
        return $menu;
    }
}
