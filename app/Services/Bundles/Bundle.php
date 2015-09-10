<?php
namespace Imbehe\Services\Bundles;

use Imbehe\Services\MiddleWare;

/**
* Payment
*/
class Bundle extends MiddleWare
{
   protected $url = 'http://10.138.84.138:8002/osb/services/FulfillProduct_1_0';
   protected $customerId;
   protected $productId;

   /**
 * Send SMS 
 * @param  string $customerId the person who is buying the pack e.g 250722123127
 * @param  string $productId  the unique id for the product e.g 00011
 * @return bool         
 */
public function buy($customerId,$productId)
{
   $this->customerId = $customerId;
   $this->productId = $productId;
   $this->makeRequest();   
   $response =  $this->sendRequest();

   return $this->cleanResponse($response);
}
/**
 * Make the Fullfillment engine request
 * @return true  
 */
public function makeRequest(){
//Store your XML Request in a variable
$this->request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v1="http://xmlns.tigo.com/FulfillProductRequest/V1" xmlns:v3="http://xmlns.tigo.com/RequestHeader/V3" xmlns:v2="http://xmlns.tigo.com/ParameterType/V2" xmlns:cor="http://soa.mic.co.af/coredata_1">
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
      <v1:FulfillProductRequest>
         <v3:RequestHeader>
            <v3:GeneralConsumerInformation>
               <v3:consumerID>TIGO</v3:consumerID>
               <!--Optional:-->
               <v3:transactionID>rewt54356</v3:transactionID>
               <v3:country>RWA</v3:country>
               <v3:correlationID>113</v3:correlationID>
            </v3:GeneralConsumerInformation>
         </v3:RequestHeader>
         <v1:RequestBody>
            <v1:channelId>2</v1:channelId>
            <v1:payingCustomerID>'.$this->customerId.'</v1:payingCustomerID>
            <v1:fulfillmentCustomerID>'.$this->customerId.'</v1:fulfillmentCustomerID>
            <v1:productId>'.$this->productId.'</v1:productId>
            <!--Optional:-->
            <v1:externalTransactionID>'.$this->customerId.time().'</v1:externalTransactionID>
            <!--Optional:-->
            <v1:comment>ImbeheApp</v1:comment>
            <!--Optional:-->
         </v1:RequestBody>
      </v1:FulfillProductRequest>
   </soapenv:Body>
</soapenv:Envelope>';
      }
}