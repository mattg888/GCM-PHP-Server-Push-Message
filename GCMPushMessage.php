<?php
/**
 * Class to send push notifications using Google Cloud Messaging for Android
 *
 * Example usage
 * -----------------------
 * $an = new GCMPushMessage($apiKey);
 * $an->setDevices($devices);
 * $response = $an->send($message);
 * -----------------------
 *
 * $apiKey Your GCM api key
 * $devices An array or string of registered device tokens
 * $message The mesasge you want to push out
 *
 * @author Matt Grundy
 *
 * Adapted from the code available at:
 * http://stackoverflow.com/questions/11242743/gcm-with-php-google-cloud-messaging
 *
 * Modify: Artem Yankovskiy (artemyankovskiy@gmail.com)
 *
 **/
class GCMPushMessage {

    private $url = 'https://android.googleapis.com/gcm/send';
    private $serverApiKey = "";
    private $devices = array();

    /**
     * Constructor
     * @param $apiKeyIn the server API key
     */
    function __construct($apiKeyIn) {
        $this->serverApiKey = $apiKeyIn;
    }

    /**
     * Set the devices to send to
     * @param mixed $deviceIds array of devices tokens for send to
     */
    public function setDevices($deviceIds) {

        if (is_array($deviceIds)) {
            $this->devices = $deviceIds;
        } else {
            $this->devices = array($deviceIds);
        }
    }

    /**
     * Send data to the device
     * @param string $message data for send
     * @param mixed $data (optional) array of data to accompany the message
     * @return assoc array  ("body", "http_code")
     */
    public function send($message, $data = false) {

        if (!is_array($this->devices) || count($this->devices) == 0) {
            $this->error("No devices set");
        }

        if (strlen($this->serverApiKey) < 8) {
            $this->error("Server API Key not set");
        }

        $fields = array(
                'registration_ids'  => $this->devices,
                'data'              => array( "message" => $message )
        );

        if (is_array($data)) {
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
        $httpBody = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        // Close connection
        curl_close($ch);

        return array("http_body" => $httpBody, "http_code" => $httpCode);
    }

    /**
     * Prints error message to screen and exit from app
     * @param string $msg error message
     */
    private function error($msg) {
        echo "Android send notification failed with error:";
        echo "\t" . $msg;
        exit(1);
    }
}
