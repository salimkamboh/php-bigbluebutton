<?php

namespace sanduhrs\bigbluebutton\tests;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use sanduhrs\BigBlueButton\Client;

class ClientTest extends TestCase
{

    /**
     * The server uri.
     *
     * @var \GuzzleHttp\Psr7\Uri
     */
    protected $uri;

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
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->uri = new Uri(getenv('BBB_URI'));
        $this->secret = getenv('BBB_SECRET');
        $this->endpoint = getenv('BBB_ENDPOINT');

        $this->client = new Client(
            $this->uri,
            $this->secret,
            $this->endpoint
        );
    }

    public function testHasUri()
    {
        $this->assertObjectHasAttribute('uri', $this->client);
    }

    public function testCanGetUri()
    {
        $uri = $this->client->getUri();
        $this->assertNotEmpty($uri);
    }

    public function testHasSecret()
    {
        $this->assertObjectHasAttribute('secret', $this->client);
    }

    public function testCanGetSecret()
    {
        $secret = $this->client->getSecret();
        $this->assertNotEmpty($secret);
    }

    public function testHasEndpoint()
    {
        $this->assertObjectHasAttribute('endpoint', $this->client);
    }

    public function testCanGetEndpoint()
    {
        $endpoint = $this->client->getEndpoint();
        $this->assertNotEmpty($endpoint);
    }
}
