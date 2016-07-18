<?php

namespace sanduhrs\BigBlueButton\Member;

use sanduhrs\BigBlueButton\Client;
use GuzzleHttp\Psr7\Uri;

/**
 * Class Document.
 *
 * @package sanduhrs\BigBlueButton
 */
class Document
{
    /**
     * The URI.
     *
     * @var \GuzzleHttp\Psr7\Uri
     */
    protected $uri;

    /**
     * The name.
     *
     * @var string
     */
    protected $name;

    /**
     * Embed the document.
     *
     * @var bool
     */
    protected $embed;

    /**
     * The BigBlueButton client.
     *
     * @var \sanduhrs\BigBlueButton\Client
     */
    protected $client;

    /**
     * Document constructor.
     *
     * @param $uri
     * @param string $name
     * @param bool $embed
     */
    public function __construct($uri, $name = '', $embed = false)
    {
        $this->uri = new Uri($uri);
        $this->name = $name;
        $this->embed = $embed;
    }

    /**
     * Get the URI.
     *
     * @return \GuzzleHttp\Psr7\Uri
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Set the URI.
     *
     * @param \GuzzleHttp\Psr7\Uri $uri
     * @return Document
     */
    public function setUri(Uri $uri)
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * Get the name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name.
     *
     * @param string $name
     * @return Document
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Is the document embedded?
     *
     * @return boolean
     */
    public function isEmbedded()
    {
        return $this->embed;
    }

    /**
     * Set the embed indicator.
     *
     * @param bool $embed
     * @return Document
     */
    public function setEmbed($embed)
    {
        $this->embed = $embed;
        return $this;
    }

    /**
     * Set the client.
     *
     * @var \sanduhrs\BigBlueButton\Client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }
}
