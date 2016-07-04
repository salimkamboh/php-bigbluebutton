<?php

/**
 * @file
 * Contains sanduhrs\BigBlueButton.
 */

namespace sanduhrs;

use sanduhrs\BigBlueButton\Server;
use sanduhrs\BigBlueButton\Client;

/**
 * Class BigBlueButton
 *
 * @package sanduhrs
 */
class BigBlueButton
{

    /**
     * The BigBlueButton library version.
     *
     * @var string
     *   A version string.
     */
    const VERSION = '0.3.0';

    /**
     * The BigBlueButton API version.
     *
     * @var string
     *   A version string.
     */
    const API_VERSION = '0.9';

    /**
     * The BigBlueButton server object.
     *
     * @var \sanduhrs\BigBlueButton\Server
     */
    protected $server;

    /**
     * The BigBlueButton client object.
     *
     * @var \sanduhrs\BigBlueButton\Client
     */
    protected $client;


    /**
     * BigBlueButton constructor.
     *
     * @param string $url
     * @param string $secret
     * @param string $endpoint
     */
    public function __construct(
        $url,
        $secret,
        $endpoint
    ) {
        $this->client = new Client($url, $secret, $endpoint);
        $this->server = new Server($this->client);
    }
}
