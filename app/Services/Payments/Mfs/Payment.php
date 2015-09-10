<?php
namespace Imbehe\Services\Payments\Mfs;

use Imbehe\Services\MiddleWare;

/**
* Payment
*/
class Payment extends MiddleWare
{
	protected $url = 'http://10.138.84.138:8002/osb/services/Purchase_2_0';
	protected $company;
	protected $sender;
	protected $pin;
	protected $amount;
   
   function __construct() {
   parent::__construct();
}

/**
 * PAY 
 * @param  string $sender     the person who is supposed to pay with tigo cash (EXAMPLE 250722123127)
 * @param  string $amount     amount to pay     (EXAMPLE 5000)
 * @param  string $pin     	  the pin for the customer (EXAMPLE 0060)
 * @param  string $company    the company ID (EXAMPLE ELEC)
 * @return bool         
 */
public function pay($sender,$amount,$pin,$company)
{
	$this->sender = $sender;
	$this->pin = $pin;
	$this->amount = $amount;
	$this->company = $company;

	$this->makeRequest();
	
	$response =  $this->sendRequest();

   return $this->cleanResponse($response);
}
/**
 * Send SMS notification
 * @param  string $to      the MSISDN with 250 that is going to receive sms
 * @param  from   $sender  the sender of the sms 
 * @param  string $message 
 * @return true  
 */
public function makeRequest(){
//Store your XML Request in a variable
$this->request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v2="http://xmlns.tigo.com/MFS/PurchaseRequest/V2" xmlns:v3="http://xmlns.tigo.com/RequestHeader/V3" xmlns:v21="http://xmlns.tigo.com/ParameterType/V2" xmlns:cor="http://soa.mic.co.af/coredata_1">
   <soapenv:Header xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
      <cor:debugFlag>true</cor:debugFlag>
      <wsse:Security>
         <wsse:UsernameToken>
            <wsse:Username>'.$this->username.'</wsse:Username>
            <wsse:Password>'.$this->password.'</wsse:Password>
         </wsse:UsernameToken>
      </wsse:Security>
   </soapenv:Header>
   <soapenv:Body>
      <v2:PurchaseRequest>
         <v3:RequestHeader>
            <v3:GeneralConsumerInformation>
               <v3:consumerID>TIGO</v3:consumerID>
               <!--Optional:-->
               <v3:transactionID>333</v3:transactionID>
               <v3:country>RWA</v3:country>
               <v3:correlationID>111</v3:correlationID>
            </v3:GeneralConsumerInformation>
         </v3:RequestHeader>
         <v2:requestBody>
            <v2:sourceWallet>
               <v2:msisdn>'.$this->sender.'</v2:msisdn>
            </v2:sourceWallet>
            <!--Optional:-->
            <v2:targetWallet>
               <v2:msisdn>'.$this->company.'</v2:msisdn>
            </v2:targetWallet>
            <v2:password>'.$this->pin.'</v2:password>
            <v2:amount>'.$this->amount.'</v2:amount>
            <v2:internalSystem>Yes</v2:internalSystem>
            <!--Optional:-->
            <!--Optional:-->
            <v2:comment>ImbeheApp payment</v2:comment>
            <!--Optional:-->
            <v2:paymentReference></v2:paymentReference>
            <!--Optional:-->
            <v2:notificationNumber></v2:notificationNumber>
            <!--Optional:-->
         </v2:requestBody>
      </v2:PurchaseRequest>
   </soapenv:Body>
</soapenv:Envelope>';
      }
}