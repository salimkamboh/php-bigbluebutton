<?php

use PHPUnit\Framework\TestCase;
use sanduhrs\BigBlueButton\Server;
use sanduhrs\BigBlueButton\Client;

class ClientTest extends TestCase
{

    /**
     * The server url.
     *
     * @var string
     */
    protected $url;

    /**
     * The server secret.
     *
     * @var string
     */
    protected $secret;

    /**
     * The api endpoint.
     *
     * @var string
     */
    protected $endpoint;

    /**
     * The client.
     *
     * @var \sanduhrs\BigBlueButton\Client
     */
    protected $client;

    /**
     * ClientTest constructor.
     *
     * @param null|string $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '') {
        parent::__construct($name, $data, $dataName);

        $this->url = getenv('BBB_URL');
        $this->secret = getenv('BBB_SECRET');
        $this->endpoint = getenv('BBB_ENDPOINT');

        $this->client = new Client(
          $this->url,
          $this->secret,
          $this->endpoint
        );
    }

    public function testHasUrl() {
        $this->assertObjectHasAttribute('url', $this->client);
    }

    public function testCanGetUrl() {
        $url = $this->client->getUrl();
        $this->assertNotEmpty($url);
    }

    public function testHasSecret() {
        $this->assertObjectHasAttribute('secret', $this->client);
    }

    public function testCanGetSecret() {
        $secret = $this->client->getSecret();
        $this->assertNotEmpty($secret);
    }

    public function testHasEndpoint() {
        $this->assertObjectHasAttribute('endpoint', $this->client);
    }

    public function testCanGetEndpoint() {
        $endpoint = $this->client->getEndpoint();
        $this->assertNotEmpty($endpoint);
    }

}
