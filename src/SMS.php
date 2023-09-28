<?php

namespace Jccdbytes\SmsKit;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class SMS {
    protected $API_USERNAME;
    protected $API_PASSWORD;
    protected $SENDER_ID;
    protected $GW_URL;
    protected $httpClient;
    protected $LANGUAGE_TYPE = 1;

    public function __construct(){

        $this->API_USERNAME = getenv('SMS_API_USERNAME') ?? null;
        $this->API_PASSWORD = getenv('SMS_API_PASSWORD') ?? null;
        $this->SENDER_ID = getenv('SMS_SENDER') ?? 'SMS-KIT';
        $this->GW_URL = getenv('GW_URL') ?? null;

        $this->httpClient = new Client();
    }

    /**
     Function: Send the sms
     * use the api to send the sms to target recipient
     * @param string $send_to mobile number of the recipient
     * @param string $message text message or the body of the sms
     * @return array response
     */
    public function sendSMS($send_to, $message){
        $queryParams = [
            'apiusername' => $this->API_USERNAME,
            'apipassword' => $this->API_PASSWORD,
            'senderid'    => $this->SENDER_ID,
            'mobileno'    => $send_to,
            'message'     => stripslashes($message),
            'languagetype' => $this->LANGUAGE_TYPE,
        ];

        try {
            $response = $this->httpClient->get($this->GW_URL, ['query' => $queryParams]);

            if($response->getStatusCode() !== 200){
                return [
                    'message' => 'Failed to send SMS',
                    'code' => 0
                ];
            }

            $apiResponse = $response->getBody()->getContents();
            if($apiResponse > 0){
                return [
                    'message' => "Success with MT ID: {$apiResponse}",
                    'code'    => 1
                ];
            }else {
                return [
                    'message' => "API Error: {$apiResponse}",
                    'code'    => 0
                ];
            }
        } catch (RequestException $e) {
            return [
                'message' => 'Failed to send SMS: ' . $e->getMessage(),
                'code' => 0
            ];
        }
    }

    public function setLanguageType(int|string $type){
        $this->LANGUAGE_TYPE = $type;
    }

    /**
     Method call configuration
     * set the configuration of the api by using a method call
     * @param string $apiUsername 
     * @param string $apiPassword
     * @param string $sender
     * @param string $gwUrl 
     * 
     * @return void
     */
    public function setConfig($apiUsername , $apiPassword, $sender, $gwUrl): void{
        $this->API_USERNAME = $apiUsername ?? null;
        $this->API_PASSWORD = $apiPassword ?? null;
        $this->SENDER_ID = $sender ?? 'SMS-KIT';
        $this->GW_URL = $gwUrl ?? null;
    }

}
