<?php 
namespace Imbehe\Services;

/**
 * Middle ware parent classe
 */
 class MiddleWare
 {
 	
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
          curl_setopt($soap_do, CURLOPT_USERPWD,$this->username . ":" . $password="tigo1234");
          
          $result = curl_exec($soap_do);
      // Check if we have error in sending this request
      if (strpos($result,'OK')) {
      	return true;
      }
      return false;
	}   

 } 