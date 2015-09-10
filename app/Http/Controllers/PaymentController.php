<?php

namespace Imbehe\Http\Controllers;

use Illuminate\Http\Request;
use Imbehe\Services\Payments\Mfs\Payment;
use Imbehe\Services\Bundles\Bundle;
use Imbehe\Http\Requests;
use Imbehe\Http\Controllers\Controller;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function payWithMfs($msisdn,$amount,$code,$company, Payment $payment)
    {
        return $payment->pay($msisdn,$amount,$code,$company);
    }

    /**
     * [payWithAirtime description]
     * @param  string $msisdn msisdn to be charged
     * @param  string $code   product code
     * @param  Bundle $bundle Bundle service
     * @return string         results
     */
    public function payWithAirtime($msisdn,$code,Bundle $bundle)
    {
        return $bundle->buy($msisdn,$code);
    }
}
