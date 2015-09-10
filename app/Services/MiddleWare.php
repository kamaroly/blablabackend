<?php 
namespace Imbehe\Services;

/**
 * Middle ware parent classe
 */
 class MiddleWare
 {  
  protected $url = "http://10.138.84.138:8002/osb/services/SendNotification_1_0";
  protected $username;
  protected $password;
  protected $RegexPattern = "/description>(.*?)<\//s";

  function __construct() {
    $this->username = env('MW_USERNAME');
    $this->password = env('MW_PASSWORD');
  }
 	
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
          
          return  curl_exec($soap_do);
   
	}   

  /**
   * Clean the response return by the soap server
   * @param  string $response [description]
   * @return [type]           [description]
   */
  public function cleanResponse($response)
  {
   preg_match($this->RegexPattern,$response,$aMatch);
   return isset($aMatch[1]) ? $aMatch[1] : $aMatch;
  }

 } 