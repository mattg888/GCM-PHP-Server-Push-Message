Google Cloud Push Messaging PHP Server Class
--------------------------------------------

A PHP class to send messages to devices registered through Google Cloud Messaging.

See:
http://developer.android.com/guide/google/gcm/index.html

Based on the code available at:
http://stackoverflow.com/questions/11242743/gcm-with-php-google-cloud-messaging

Example usage
-----------------------
```php
$apiKey = "YOUR GOOGLE API SERVER KEY";
$devices = array('YOUR REGISTERED DEVICE ID');
$message = "The message to send";

$gcpm = new GCMPushMessage($apiKey);
$gcpm->setDevices($devices);
$response = $gcpm->send($message, array('title' => 'Test title'));
```

How to obtain a Google Server API Key
-----------------------
-	Go to the Google Console https://console.developers.google.com
-	Create a new project / open project
-	Click on 'APIs & Auth' on the left
-	Find the 'Google Cloud Messaging for Android' option, and press off to turn it on
-	Go to the creditials tab on the left
-	Go the 'Public API access' section and click 'Create new key'
-	Choose 'Server key' and click 'Create'
-	The API key is now shown under the section 'Key for server applications'
