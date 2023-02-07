<?php

namespace Raygun\Raygun4WP;

use GuzzleHttp\Client;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Raygun4php\Interfaces\TransportInterface;
use Raygun4php\Transports\GuzzleAsync;
use Raygun4php\Transports\GuzzleSync;

class RaygunClientManager {
    // Singleton-esque RaygunClient instance
    private static RaygunClient $instance;
    private static Client $httpClient;
    private static Logger $logger;
    // Remember the current async state to detect changes
    private static bool $currentAsyncState;

    /**
     * Get the singleton-esque RaygunClient instance
     *
     * Parameters override WordPress options:
     * @param string|null $customApiKey
     * @param bool|null $customUserTrackingState
     * @param bool|null $customAsyncState
     *
     * @return RaygunClient
     */
    public static function getInstance(string $customApiKey = null, bool $customUserTrackingState = null, bool $customAsyncState = null): RaygunClient {
        $userTracking = $customUserTrackingState ?? 1 == get_option('rg4wp_usertracking');
        $async = $customAsyncState ?? 1 == get_option('rg4wp_async');

        if (!isset(self::$instance)) {
            // An instance has not yet been created...
            $apiKey = $customApiKey ?? get_option('rg4wp_apikey');
            // Initialize httpClient:
            self::$httpClient = new Client([
                'base_uri' => 'https://api.raygun.com',
                'timeout' => 2.0,
                'headers' => [
                    'X-ApiKey' => $apiKey,
                ],
            ]);
            // Initialize logger:
            $logPath = self::getLogsPath();
            if ($logPath) {
                self::$logger = new Logger('raygun');
                self::$logger
                    ->pushHandler(new StreamHandler($logPath))
                    ->pushHandler(new FirePHPHandler());
            }

            self::$instance = new RaygunClient(self::getTransport($async), !$userTracking);
            self::$currentAsyncState = $async;
        } else {
            // An instance already exists...
            if ($async != self::$currentAsyncState) {
                // Ensure async state changes take effect
                self::$instance = self::$instance->constructNew(self::getTransport($async), $userTracking);
                self::$currentAsyncState = $async;
            } else if ($userTracking == self::$instance->getDisableUserTracking()) {
                // Ensure user tracking state changes take effect
                self::$instance->setDisableUserTracking(!$userTracking);
            }
        }
        return self::$instance;
    }

    private static function getTransport(bool $async): TransportInterface {
        /**
         * Create the appropriate asynchronous or synchronous transport
         * @see https://raygun.com/documentation/language-guides/php/crash-reporting/installation/#synchronous-usage
         */
        $transport = $async ? new GuzzleAsync(self::$httpClient) : new GuzzleSync(self::$httpClient);
        if (isset(self::$logger)) {
            // Attach the logger to the transport to log failed crash reports
            $transport->setLogger(self::$logger);
        }
        return $transport;
    }

    protected static function getLogsPath(): string {
        if (defined('WP_CONTENT_DIR') && WP_CONTENT_DIR && is_string(WP_CONTENT_DIR)) {
            return WP_CONTENT_DIR . '/debug.log';
        }
        return 'php://memory';
    }
}
