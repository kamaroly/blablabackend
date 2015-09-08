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
        dd($payment->pay($msisdn,$amount,$code,$company));
    }

    public function payWithAirtime($msisdn,$code,Bundle $bundle)
    {
        dd($bundle->buy($msisdn,$code));
    }
}
