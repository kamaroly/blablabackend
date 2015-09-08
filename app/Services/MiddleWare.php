<?php 
namespace Imbehe\Services;

/**
 * Middle ware parent classe
 */
 class MiddleWare
 {  
  protected $url = "http://10.138.84.138:8002/osb/services/SendNotification_1_0";
  protected $username='test_mw_osb';
  protected $password='tigo1234';
  protected $RegexPattern = "/<cmn\:description>(.*?)<\/cmn\:description>/s";
 	
      /**
       * Send request to the SOAP server
       * @return     response
       */
      public function sendRequest()
      {
          $soap_do = curl_init(); 
          curl_setopt($soap_do, CURLOPT_URL,            $this->url );   
          curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10); 
          curl_setopt($soap_do, CURLOPT_TIMEOUT,        10); 
          curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
          curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);  
          curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false); 
          curl_setopt($soap_do, CURLOPT_POST,           true ); 
          curl_setopt($soap_do, CURLOPT_POSTFIELDS,    $this->request); 
          curl_setopt($soap_do, CURLOPT_HTTPHEADER,     array('Content-Type: text/xml; charset=utf-8', 'Content-Length: '.strlen($this->request) )); 
          curl_setopt($soap_do, CURLOPT_USERPWD,$this->username . ":" . $this->password);
          
          $result = curl_exec($soap_do);
      // Check if we have error in sending this request
      if (strpos($result,'OK')) {
      	return true;
      }
      return false;
	}   

 } 