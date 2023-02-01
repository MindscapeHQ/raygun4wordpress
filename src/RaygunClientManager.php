<?php

namespace Raygun\Raygun4WP;

use GuzzleHttp\Client;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Raygun4php\Transports\GuzzleAsync;
use Raygun4php\Transports\GuzzleSync;

class RaygunClientManager {
    // Singleton-esque RaygunClient instance
    private static RaygunClient $instance;
    // Store RaygunClient modifiers for reuse
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
            // An instance has not yet been created
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

            self::createNewInstance($async, $userTracking);
        } else {
            // An instance already exists
            if ($async != self::$currentAsyncState) {
                // Ensure async state changes take effect
                self::createNewInstance($async, $userTracking); // Also updates user tracking state
            } else {
                // Ensure user tracking state changes take effect
                self::$instance->setDisableUserTracking(!$userTracking);
            }
        }
        return self::$instance;
    }

    private static function createNewInstance($async, $userTracking): void {
        /**
         * Create the appropriate asynchronous or synchronous transport
         * @see https://raygun.com/documentation/language-guides/php/crash-reporting/installation/#synchronous-usage
         */
        $transport = $async ? new GuzzleAsync(self::$httpClient) : new GuzzleSync(self::$httpClient);

        if (isset(self::$logger)) {
            // Attach the logger to the transport
            $transport->setLogger(self::$logger);
        }

        self::$instance = self::$instance->constructNew($transport, $userTracking);
        self::$currentAsyncState = $async;
    }

    protected static function getLogsPath(): string {
        if (defined('WP_CONTENT_DIR') && WP_CONTENT_DIR && is_string(WP_CONTENT_DIR)) {
            return WP_CONTENT_DIR . '/debug.log';
        }
        return 'php://memory';
    }
}
