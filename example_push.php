<?php

include "GCMPushMessage.php";

$apiKey = "YOURGOOGLEAPIKEY";
$devices = array(
	"device1token",
	"device2token"
);
$message = "GCM Test Message";

$an = new GCMPushMessage($apiKey);
$an->setDevices($devices);

$response = $an->send($message);

echo $response;
