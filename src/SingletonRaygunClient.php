<?php

namespace Raygun\Raygun4WP;

use Raygun4php\RaygunClient;
use Raygun4php\Transports\GuzzleAsync;
use Raygun4php\Transports\GuzzleSync;
use GuzzleHttp\Client;
use Monolog\Logger;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;

class SingletonRaygunClient
{
    /**
     * The instance of Raygun Client.
     */
    private static RaygunClientWrapper $instance;

    private static string $currentParams;

    /**
     * Is the client asynchronous ?
     *
     * @return bool
     */
    public function isAsync(): bool
    {
        return method_exists(self::$instance->getTransport(), 'wait');
    }

    /**
     * Get the instance of RaygunClient.
     *
     * @param $apiKey
     * @param $userTracking
     * @param $async
     *
     * @return RaygunClient
     * @throws \Exception
     */
    public static function getInstance($apiKey = null, $userTracking = null, $async = null): RaygunClient
    {
        $apiKey = $apiKey ?? get_option('rg4wp_apikey');
        $userTracking = $userTracking ?? get_option('rg4wp_usertracking');
        $async = $async ?? get_option('rg4wp_async');
        // Check is $instance has been set
        if (!isset(self::$instance) || self::$currentParams != $async . $userTracking . $apiKey) {
            self::$currentParams = $async . $userTracking . $apiKey;
            // Creates sets object to instance
            $httpClient = new Client([
                'base_uri' => 'https://api.raygun.com',
                'headers'  => [
                    'X-ApiKey' => $apiKey,
                ],
            ]);

            $isAsync = $async === "1";

            /**
             * Asynchronous usage or synchronous usage
             *
             * @see https://raygun.com/documentation/language-guides/php/crash-reporting/installation/#synchronous-usage
             */
            $transport = $isAsync ? new GuzzleAsync($httpClient) : new GuzzleSync($httpClient);

            /**
             * Start logging logic.
             */
            $logPath = self::getLogsPath();
            if ($logPath) {
                // Create logger
                $logger = new Logger('raygun');

                $logger
                    ->pushHandler(new StreamHandler($logPath))
                    ->pushHandler(new FirePHPHandler());

                // Attach logger to transport
                $transport->setLogger($logger);
            }

            self::$instance = new RaygunClientWrapper($transport, $userTracking);
        }

        // Returns the instance
        return self::$instance;
    }

    /**
     * Get the logs path.
     *
     * @return string
     */
    protected static function getLogsPath(): string
    {
        if (defined('WP_CONTENT_DIR') && WP_CONTENT_DIR && is_string(WP_CONTENT_DIR)) {
            return WP_CONTENT_DIR . '/debug.log';
        }

        return 'php://memory';
    }
}
