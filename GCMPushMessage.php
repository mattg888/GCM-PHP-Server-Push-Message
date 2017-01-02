<?php
/*
	Class to send push notifications using Google Cloud Messaging for Android

	Example usage
	-----------------------
	$an = new GCMPushMessage($apiKey);
	$an->setDevices($devices);
	$response = $an->send($message);
	-----------------------
	
	$apiKey Your GCM api key
	$devices An array or string of registered device tokens
	$message The mesasge you want to push out

	@author Matt Grundy

	Adapted from the code available at:
	http://stackoverflow.com/questions/11242743/gcm-with-php-google-cloud-messaging

*/
class GCMPushMessage {

	// the URL of the GCM API endpoint
	private $url = 'https://android.googleapis.com/gcm/send';
	// the server API key - setup on class init
	private $serverApiKey = "";
	// array of devices to send to
	private $devices = array();
	
	/*
		Constructor
		@param $apiKeyIn the server API key
	*/
	function __construct($apiKeyIn){
		$this->serverApiKey = $apiKeyIn;
	}

	/*
		Set the devices to send to
		@param $deviceIds array of device tokens to send to
	*/
	function setDevices($deviceIds){
		if(is_array($deviceIds)){
			$this->devices = $deviceIds;
		} else {
			$this->devices = array($deviceIds);
		}
	}

	/*
		Send the message to the device
		@param $message The message to send
		@param $data Array of data to accompany the message
	*/
	function send($message, $data = false){
		
		if(!is_array($this->devices) || count($this->devices) == 0){
			throw new GCMPushMessageArgumentException("No devices set");
		}
		
		if(strlen($this->serverApiKey) < 8){
			throw new GCMPushMessageArgumentException("Server API Key not set");
		}
		
		$fields = array(
			'registration_ids'  => $this->devices,
			'data'              => array( "message" => $message ),
		);
		
		if(is_array($data)){
			foreach ($data as $key => $value) {
				$fields['data'][$key] = $value;
			}
		}

		$headers = array( 
			'Authorization: key=' . $this->serverApiKey,
			'Content-Type: application/json'
		);

		// Open connection
		$ch = curl_init();
		
		// Set the url, number of POST vars, POST data
		curl_setopt( $ch, CURLOPT_URL, $this->url );
		
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		
		curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
		
		// Avoids problem with https certificate
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
		
		// Execute post
		$result = curl_exec($ch);
		
		// Close connection
		curl_close($ch);
		
		return $result;
	}
	
}

class GCMPushMessageArgumentException extends Exception {
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}

