<?php
namespace Imbehe\Services\Payments\Mfs;

use Imbehe\Services\MiddleWare;

/**
* Payment
*/
class Payment extends MiddleWare
{
	protected $url = 'http://10.138.84.138:8002/osb/services/Payments_2_0';
	protected $company;
	protected $sender;
	protected $pin;
	protected $amount;

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
	
	return $this->sendRequest();
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
$this->request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v1="http://xmlns.tigo.com/MFS/PaymentsRequest/V1" xmlns:v3="http://xmlns.tigo.com/RequestHeader/V3" xmlns:v2="http://xmlns.tigo.com/ParameterType/V2" xmlns:cor="http://soa.mic.co.af/coredata_1">
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
      <v1:payBillRequest>
         <v3:RequestHeader>
            <v3:GeneralConsumerInformation>
               <v3:consumerID>TIGO</v3:consumerID>
               <!--Optional:-->
               <v3:transactionID>1234</v3:transactionID>
               <v3:country>RWA</v3:country>
               <v3:correlationID>qwerty</v3:correlationID>
            </v3:GeneralConsumerInformation>
         </v3:RequestHeader>
         <v1:requestBody>
            <v1:reference>1234123</v1:reference>
            <v1:sourceWallet>
               <v1:msisdn>'.$this->sender.'</v1:msisdn>
            </v1:sourceWallet>
            <v1:targetWallet>
               <v1:username>'.$this->company.'</v1:username>
            </v1:targetWallet>
            <!--Optional:-->
            <v1:password>1414</v1:password>
            <v1:amount>'.$this->amount.'</v1:amount>
            <!--Optional:-->
         </v1:requestBody>
      </v1:payBillRequest>
   </soapenv:Body>
</soapenv:Envelope>';
      }
}