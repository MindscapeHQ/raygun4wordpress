<?php


namespace Androlax2\Raygun4Wordpress;

use GuzzleHttp\Client;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Raygun4php\Interfaces\TransportInterface;
use Raygun4php\RaygunClient as BaseRaygunClient;
use Raygun4php\Transports\GuzzleAsync;
use Raygun4php\Transports\GuzzleSync;

class RaygunClient extends BaseRaygunClient
{
    /**
     * The instance of Raygun Client.
     *
     * @var RaygunClient
     */
    private static RaygunClient $instance;

    /**
     * Return the transport used.
     *
     * @return TransportInterface
     */
    public function getTransport(): TransportInterface
    {
        return $this->transport;
    }

    /**
     * Is the client asynchronous ?
     *
     * @return bool
     */
    public function isAsync(): bool
    {
        return method_exists($this->getTransport(), 'wait');
    }

    /**
     * Get the instance of RaygunClient.
     *
     * @param $rg4wp_apikey
     * @param $rg4wp_async
     * @param $rg4wp_usertracking
     *
     * @return RaygunClient
     * @throws \Exception
     */
    public static function getInstance($rg4wp_apikey = null, $rg4wp_usertracking = null, $rg4wp_async = null): RaygunClient
    {
        // Check is $instance has been set
        if (!isset(self::$instance)) {
            $apiKey = $rg4wp_apikey ?? get_option('rg4wp_apikey');
            $userTracking = $rg4wp_usertracking ?? get_option('rg4wp_usertracking');
            $async = $rg4wp_async ?? get_option('rg4wp_async');

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

            if (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG) {
                $logPath = WP_DEBUG_LOG;
            } else if (defined('WP_CONTENT_DIR') && WP_CONTENT_DIR) {
                $logPath = WP_CONTENT_DIR;
            }

            if (isset($logPath) && $logPath) {
                // Create logger
                $logger = new Logger('raygun');

                $logger
                    ->pushHandler(new StreamHandler($logPath))
                    ->pushHandler(new FirePHPHandler());

                // Attach logger to transport
                $transport->setLogger($logger);
            }

            self::$instance = new RaygunClient($transport, !$userTracking);
        }

        // Returns the instance
        return self::$instance;
    }

    /**
     * Create an instance with defined options.
     *
     * @param $rg4wp_apikey
     * @param $rg4wp_async
     * @param $rg4wp_usertracking
     *
     * @return RaygunClient
     * @throws \Exception
     */
    public static function forOptions($rg4wp_apikey, $rg4wp_usertracking, $rg4wp_async = 'not_async'): RaygunClient
    {
        return self::getInstance($rg4wp_apikey, $rg4wp_usertracking, $rg4wp_async);
    }
}