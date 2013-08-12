<?php
echo '<!DOCTYPE html>
	<html>
	<head>
	<title>Raygun4WP test error</title>
	</head>
	<body>';
	if ($_GET['rg4wp_status'] && function_exists('curl_version') && $_GET['rg4wp_apikey'])
      {
        require_once dirname(__FILE__).'/external/raygun4php/src/Raygun4php/RaygunClient.php';
        $client = new Raygun4php\RaygunClient($_GET['rg4wp_apikey']);               

        $result = $client->SendError(404, 'Congratulations, Raygun4WP is working correctly!', '0', '0');         
        if ($result == '403')
        {
        	echo 'The Raygun service did not accept your API key, please enter there is a valid API key in the field
        	for an application you have created, then hit \'Save Changes.\'';
        }
    	else if ($result == '202')
    	{
    		echo 'Raygun appears to have accepted the test issue, now check your <a href="http://app.raygun.io" target="_blank">dashboard</a>!';
    	}
      }
      else
      {
      	echo 'Something was missing! Please check that the status has a green circle beside it, your API key is pasted in and you have saved the settings';
      }
      echo '<br /><a href="javascript:window.history.back();">Back</a></body></html>';
?>