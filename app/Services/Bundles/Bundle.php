<?php 
namespace Imbehe\Services\Bandles;
use GuzzleHttp\Client;
use Imbehe\Services\MiddleWare;
/**
 * SendSms notification
 */
class Bundle extends MiddleWare{
	protected $url = "http://10.138.84.138:8002/osb/services/SendNotification_1_0";
	protected $username='test_mw_osb';
	protected $password='tigo1234';
	protected $RegexPattern = "/<cmn\:description>(.*?)<\/cmn\:description>/s";
	protected $request ;
	public    $receiver ;
	public    $sender;
	public    $message;

/**
 * Send SMS 
 * @param  string $receiver the person who is supposed to receive sms
 * @param  string $message  message to be sent to the subscriber
 * @param  string $sender   from
 * @return bool         
 */
public function send($receiver,$message,$sender ='Imbehe')
{
	$this->receiver = $receiver;
	$this->sender = $sender;
	$this->message = $message;
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
$this->request = '<!--Test to verify the SMS notification, when a valid customerId and message is 
passed in the request along with all the header elements and optional elements-->
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v1="http://xmlns.tigo.com/SendNotificationRequest/V1" xmlns:v3="http://xmlns.tigo.com/RequestHeader/V3" xmlns:v2="http://xmlns.tigo.com/ParameterType/V2" xmlns:cor="http://soa.mic.co.af/coredata_1">
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
      <v1:SendNotificationRequest>
         <v3:RequestHeader>
            <v3:GeneralConsumerInformation>
               <!--Optional:-->
               <v3:consumerID>TIGO</v3:consumerID>
               <!--Optional:-->
               <v3:transactionID>345cyz</v3:transactionID>
               <v3:country>RWA</v3:country>
               <v3:correlationID>1234</v3:correlationID>
            </v3:GeneralConsumerInformation>
         </v3:RequestHeader>
         <v1:RequestBody>
            <v1:channelId>SMS</v1:channelId>
            <v1:customerId>'.$this->receiver.'</v1:customerId>
            <v1:message>'.$this->message.'</v1:message>
           <!--Optional:-->
            <v1:additionalParameters>
               <v2:ParameterType>
                  <v2:parameterName>smsShortCode</v2:parameterName>
                  <v2:parameterValue>'.$this->sender.'</v2:parameterValue>
               </v2:ParameterType>               
            </v1:additionalParameters>            
            <v1:externalTransactionId>1234</v1:externalTransactionId>
            <!--Optional:-->
            <v1:comment>Imbehe Notification</v1:comment>
         </v1:RequestBody>
      </v1:SendNotificationRequest>
   </soapenv:Body>
</soapenv:Envelope>';
      }

	/**
	 * Clean the response return by the soap server
	 * @param  string $response [description]
	 * @return [type]           [description]
	 */
	public function cleanResponse($response)
	{
	 preg_match($this->RegexPattern,$response,$aMatch);
	  dd($aMatch);
	}

}