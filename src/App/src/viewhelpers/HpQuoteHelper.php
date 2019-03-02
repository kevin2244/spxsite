<?php
/**
 * @copyright Kevin Smith 2019
 * Date: 02/02/2019
 * Time: 21:54
 */
declare(strict_types=1);

namespace App\viewhelpers;

use Zend\View\Helper\AbstractHelper;
use function extract;
use function htmlspecialchars;
use function is_string;

class HpQuoteHelper extends AbstractHelper
{

    public function __construct()
    {

    }

    public function __invoke(array $data)
    {
        $ident = 'thiscar';
        $paraident = 'par-' . $ident;
        $priceident = 'price-' . $ident;
        $scrappageident = 'scrappage-' . $ident;

        //TODO better filtering of inputs,
        //this is only sanitization of strings
        foreach ($data as $k => $v) {
            if (is_string($v)) {
                $data[$k] = htmlspecialchars($v);
            }
        }
        extract($data);
        $deposit = $deposit ?? 5000;

        //TODO - scrappage discount must be accessible via API
        //Or provide estimate based on price/marque/type etc.
        $scrappagediscount = $scrappagediscount ?? 2000;
        $hpform= <<<EOF
        <div id="$paraident" class="$ident marker quotegrid">
            <div class="quotegridfieldheader">
                HP Quote Estimate        
            </div>
            
            <div class="quotegridtext">
                <b><i>STEP 1.</i></b> Adjust inputs as necessary, monthly payments will update instantly.
                    For example if you think you can get a zero interest rate deal enter 0 in the Interest Rate field
                    or if your purchase price is different adjust the price field.
            </div>    
            
            <div class="quotegridfield">Price(£)........</div>
            <div class="quotegridvalue"><input type="text" class="quoteinput price priceinput $paraident" value="$price_indicative" autocomplete="off"></div>
            
            <div class="quotegridfield">Deposit(£)........</div>
            <div class="quotegridvalue"><input type="text" class="quoteinput spxinput deposit $paraident" value="$deposit" autocomplete="off"></div>
            
            <div class="quotegridfield">Scrappage/Trade-In (£)........</div>
            <div class="quotegridvalue"><input type="text" class="quoteinput spxinput scrappagedisc $paraident" value="$scrappagediscount"></div>
        
            <div class="quotegridfield">Amount to finance........</div>
            <div class="quotegridvalue"> <span class="quotedisplay financeamount $paraident">0</span></div>
        
            <div class="quotegridfield">No. monthly payments........</div>
            <div class="quotegridvalue"><input type="text" class="quoteinput spxinput numpayments $paraident" value="48" ></div>
        
            <div class="quotegridfield">Interest Rate(%)........</div>
            <div class="quotegridvalue"><input type="text" class="quoteinput spxinput interestrate $paraident" value="5.9"></div>
            
            <div class="quotegridfield">Est. Monthly Payment(£).....</div>
            <div class="quotegridvalue"><span style="color:green; font-weight:bold; font-size:xx-large" class="quotedisplay monthlypayment $paraident">0</span></div>    
        
            <div class="quotegridtext">
               <b><i>STEP 2.</i></b> Get it financed at <a href="https://www.paidonresults.net/c/49722/1/1819/0" style="font-size:x-large">Car Finance Deals</a> 
            </div>
        
                
        </div>
EOF;
        return $hpform;
    }
}