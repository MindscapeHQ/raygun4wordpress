<?php

require_once sprintf("%s/vendor/autoload.php", dirname(__FILE__));

?>

<!DOCTYPE html>
<html>
<head>
    <title>Raygun4WP test error</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <style>
        body {
            background: #f1f1f1;
            color: #444;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            font-size: 13px;
            line-height: 1.4em;
            min-width: 600px;
        }
    </style>
</head>
<body>

<div class="rg4wp-container">
    <div class="rg4wp-module">

        <p class="rg4wp-text">
            <?php

            if ($_GET['rg4wp_status'] && function_exists('curl_version') && $_GET['rg4wp_apikey']) {

                $client = RaygunClient::forOptions($_GET['rg4wp_apikey'], $_GET['rg4wp_usertracking']);

                if ($_GET['rg4wp_usertracking']) {
                    $client->SetUser($_GET['user']);
                }

                $result = $client->SendError(404, 'Congratulations, Raygun4WP is working correctly!', '0', '0');

                if ($result) {
                    echo 'Raygun has accepted the test issue. Check your <a href="http://app.raygun.com" target="_blank">dashboard</a> to see the issue details!';
                } else {
                    echo 'Something is missing! Please check that you have enabled Serverside error tracking, the API key is pasted in and you have saved the settings.';
                }
            }

            ?>
        </p>

        <a class="rg4wp-button" href="/wp-admin/admin.php?page=rg4wp-settings">Back</a>

    </div>
</div>
</body>
</html>
