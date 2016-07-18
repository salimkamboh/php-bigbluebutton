<?php

namespace sanduhrs\bigbluebutton\tests;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use sanduhrs\BigBlueButton;

class BigBlueButtonTest extends TestCase
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
     * The BigBlueButton object.
     *
     * @var \sanduhrs\BigBlueButton
     */
    protected $bigBlueButton;

    /**
     * BigBlueButtonTest constructor.
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

        $this->bigBlueButton = new BigBlueButton(
            $this->uri,
            $this->secret,
            $this->endpoint
        );
    }

    public function testCanGetVersion()
    {
        $version = $this->bigBlueButton->getVersion();
        $this->assertNotEmpty($version);
    }

    public function testCanGetApiVersion()
    {
        $api_version = $this->bigBlueButton->getApiVersion();
        $this->assertNotEmpty($api_version);
    }

    public function testHasServer()
    {
        $this->assertObjectHasAttribute('server', $this->bigBlueButton);
    }

    public function testCanGetServer()
    {
        $server = $this->bigBlueButton->getServer();
        $this->assertNotEmpty($server);
    }

    public function testHasClient()
    {
        $this->assertObjectHasAttribute('client', $this->bigBlueButton);
    }

    public function testCanGetClient()
    {
        $client = $this->bigBlueButton->getClient();
        $this->assertNotEmpty($client);
    }
}
