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

Enable the API
-	Click 'ENABLE API' (blue top button)
-	Search for 'Google Cloud Messaging', click the link and click 'ENABLE'

Get a server API key
-	Go to https://console.firebase.google.com and select your project your created in the Google console
-	Click the cog icon on the left and click 'Project settings'
-	Go to the 'CLOUD MESSAGING' tab
-	Your server API key will be listed here (for use with this class)
-	Your sender ID (for use within your app) will also be listed here
