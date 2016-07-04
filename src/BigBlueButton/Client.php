<?php

namespace sanduhrs\BigBlueButton;

use GuzzleHttp\Client as HTTPClient;
use sanduhrs\BigBlueButton\BigBlueButtonException;

/**
 * Class Client
 *
 * @package sanduhrs\BigBlueButton
 */
class Client
{
    /**
     * The server URL.
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
     * The HTTP client.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Client constructor.
     *
     * @param $url
     * @param $secret
     * @param $endpoint
     */
    public function __construct(
        $url,
        $secret,
        $endpoint
    ) {
        $this->url = $url;
        $this->secret = $secret;
        $this->endpoint = $endpoint;
        $this->client = new HTTPClient();
    }

    /**
     * Get URL.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get Secret.
     *
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * Get Endpoint.
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Generate checksum.
     *
     * @param string $call
     *   the API call identifier.
     * @param array $options
     *   The API call options.
     *
     * @return string
     *   The generated checksum.
     */
    public function checksum($call, $options)
    {
        // Generate query string.
        $query_string = $this->generateQueryString($options);
        // Generate the checksum.
        $checksum = sha1($call . $query_string . $this->secret);
        return $checksum;
    }

    /**
     * Convert raw response XML to response Object.
     *
     * @param string $raw_response
     *
     * @return object
     */
    public function xml2object($raw_response)
    {
        $xml = simplexml_load_string($raw_response);
        return json_decode(json_encode($xml));
    }

    /**
     * Clean response object from unwanted messages.
     *
     * @param object $response
     *
     * @return object
     */
    public function clean($response)
    {
        if (isset($response->returncode)) {
            unset($response->returncode);
        }
        if (isset($response->message)) {
            unset($response->message);
        }
        if (isset($response->messageKey)) {
            unset($response->messageKey);
        }
        return $response;
    }

    /**
     * Generate call URL.
     *
     * @params array $options
     *   The query parameters.
     *
     * @return string
     *   A properly formatted call URL.
     */
    public function generateURL($call, $options = [])
    {
        $this->prepareQueryOptions($options);
        $url = implode('', [
            $this->url,
            $this->endpoint,
            $call,
            '?',
            $this->generateQueryString($options),
            '&checksum=' . $this->checksum($call, $options),
        ]);
        return $url;
    }

    /**
     * Generate Querystring.
     *
     * @param array $options
     *   The query parameters.
     *
     * @return string
     */
    public function generateQueryString($options = [])
    {
        $query = array();
        // Encode the options.
        foreach ($options as $key => $value) {
            $query[] = $key . '=' . str_replace(['/', ' '], ['%2F', '+'], rawurlencode($value));
        }
        // Generate the querystring.
        return implode('&', $query);
    }

    /**
     * Prepare query options.
     *
     * @param array $options
     *
     * @return array
     */
    public function prepareQueryOptions($options)
    {
        foreach ($options as $key => $option) {
            if (is_bool($option)) {
                $options[$key] = $option ? 'true' : 'false';
            }
        }
        return $options;
    }

    /**
     * GET request to API endpoint.
     *
     * @param string $call
     *   The API call string.
     * @param array $options
     *   The API call options.
     *
     * @return string
     *   The xml formatted server response string.
     */
    public function getRaw($call, $options = [])
    {
        $options = $this->prepareQueryOptions($options);
        $options += [
            'checksum' => $this->checksum($call, $options),
        ];
        $response = $this->client->request(
            'GET',
            $this->url . $this->endpoint . $call,
            ['query' => $options]
        );
        return $response->getBody();
    }

    /**
     * GET request to API endpoint.
     *
     * @param string $call
     *   The API call string.
     * @param array $options
     *   The API call options.
     *
     * @throws \Exception
     *
     * @return object
     *   The response data as object.
     */
    public function get($call, $options = [])
    {
        $raw_response = $this->getRaw($call, $options);
        $response = $this->xml2object($raw_response);

        if ($response->returncode === 'SUCCESS') {
            $response = $this->clean($response);
        } elseif (isset($response->message)) {
            throw new BigBlueButtonException($response->message);
        } else {
            throw new BigBlueButtonException('An unknown error occured while communicating with the server.');
        }
        return $response;
    }

    /**
     * POST request to API endpoint.
     *
     * @param string $call
     *   The API call string.
     * @param array $options
     *   The API call options.
     *
     * @return string
     *   The xml formatted server response string.
     */
    public function postRaw($call, $options = [])
    {
        array_unique($options, SORT_STRING);
        $options = $this->prepareQueryOptions($options);
        $options += [
            'checksum' => $this->checksum($call, $options),
        ];
        $response = $this->client->request(
            'POST',
            $this->url . $this->endpoint . $call,
            ['form_params' => $options]
        );
        return $response->getBody();
    }

    /**
     * POST request to API endpoint.
     *
     * @param string $call
     *   The API call string.
     * @param array $options
     *   The API call options.
     *
     * @throws \Exception
     *
     * @return string
     *   The json formatted server response string.
     */
    public function post($call, $options = [])
    {
        $raw = $this->postRaw($call, $options);
        $xml = simplexml_load_string($raw);

        list($element) = $xml->xpath('/*/returncode');
        // @todo Throw exception if $element[0] != 'SUCCESS'
        if (isset($element[0])) {
            unset($element[0]);
        }
        // Reformat as json.
        return json_decode(json_encode($xml));
    }
}
