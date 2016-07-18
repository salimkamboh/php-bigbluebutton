<?php

namespace sanduhrs\BigBlueButton\Member;

use sanduhrs\BigBlueButton\Client;

/**
 * Class Document.
 *
 * @package sanduhrs\BigBlueButton
 */
class Document
{
    /**
     * The URL.
     *
     * @var string
     */
    protected $url;

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
     * @param $url
     * @param string $name
     * @param bool $embed
     */
    public function __construct($url, $name = '', $embed = false)
    {
        $this->url = $url;
        $this->name = $name;
        $this->embed = $embed;
    }

    /**
     * Get the URL.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the URL.
     *
     * @param string $url
     * @return Document
     */
    public function setUrl($url)
    {
        $this->url = $url;
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
