const dospdebug = false;

function spdebug(spmessage) {
    if (dospdebug) {
        console.log('SP LOG: ' + spmessage);
    }
}

spdebug('Debugging....');

/*
TODO: this on ready call needs to be run at page level if possible
(for the particular page that it is intended to run on (carmodel.php))
*/
jQuery(document).ready(function() {
    assess('par-thiscar');
});

jQuery(".marker").on("keyup",  function() {
    assess(this.id);
});

function assess(qident) {

    spdebug('Assessing...');

    //price
    let calprice = Number(jQuery('.price.' + qident).val());

    //discount
    let calscrappagedisc = Number(jQuery('.scrappagedisc.' + qident).val());

    //deposit
    let caldeposit = Number(jQuery('.deposit.' + qident).val());

    //finamount
    let calfinanceamount = calprice - calscrappagedisc - caldeposit;

    let dispcalfinanceamount = calfinanceamount.toLocaleString('en-GB', {style: 'currency', currency: 'GBP'});

    jQuery('.financeamount.' + qident).html(dispcalfinanceamount);
    let monthlyrepayments  = Number(jQuery('.numpayments.' + qident).val()) * -1;
    let rate = Number(jQuery('.interestrate.' + qident).val() / 100 / 12);
    let monthlypayments =  calfinanceamount * (rate / (1 - ((1 + rate)**monthlyrepayments)) );
    jQuery('.monthlypayment.' + qident).html('£' + monthlypayments.toFixed(2));
}
