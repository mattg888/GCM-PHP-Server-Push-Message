A PHP class to send messages to devices registered through Google Cloud Messaging.

See:
http://developer.android.com/guide/google/gcm/index.html

Based on the code available at:
http://stackoverflow.com/questions/11242743/gcm-with-php-google-cloud-messaging

Example usage
-----------------------
```php
$apiKey = "YOUR GOOGLE API KEY";
$devices = array('YOUR REGISTERED DEVICE ID');
$message = "The message to send";

$gcpm = new GCMPushMessage($apiKey);
$gcpm->setDevices($devices);
$response = $gcpm->send($message);
```

