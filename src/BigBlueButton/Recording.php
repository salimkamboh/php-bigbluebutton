<?php

/**
 * @file
 * Contains sanduhrs\BigBlueButton\Recording.
 */

namespace sanduhrs\BigBlueButton;

use sanduhrs\BigBlueButton\Server;

/**
 * Class Recording
 *
 * @package sanduhrs\BigBlueButton
 */
class Recording
{
    /**
     * The BigBlueButton client.
     *
     * @var \sanduhrs\BigBlueButton\Client
     */
    protected $client;

    /**
     * The record id.
     *
     * @var string
     */
    protected $recordID;

    /**
     * The meeting id.
     *
     * @var string
     */
    protected $meetingID;

    /**
     * The record name.
     *
     * @var string
     */
    protected $name;

    /**
     * The published state.
     *
     * @var boolean
     */
    protected $published;

    /**
     * The start time.
     *
     * @var integer
     */
    protected $startTime;

    /**
     * The end time.
     *
     * @var integer
     */
    protected $endTime;

    /**
     * The metadata.
     *
     * @var array
     */
    protected $metadata;

    /**
     * The playback data.
     *
     * @var array
     */
    protected $playback;

    /**
     * Recording constructor.
     * @param string $recordID
     * @param array $options
     * @param \sanduhrs\BigBlueButton\Client $client
     */
    public function __construct(
        $recordID,
        $options,
        $client
    ) {
        $options = [
            'meetingID' => '',
            'name' => '',
            'published' => null,
            'startTime' => 0,
            'endTime' => 0,
            'metadata' => [],
            'playback' => [],
        ] + $options;

        $this->recordID = $recordID;
        $this->client = $client;

        foreach ($options as $key => $value) {
            if(isset($this->{$key})) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * Publish recording.
     *
     * @return mixed
     */
    public function publish()
    {
        $options = [
            'recordID' => $this->recordID,
            'publish' => 'true',
        ];
        return $this->client->get('isMeetingRunning', $options);
    }

    /**
     * Unpublish recording.
     *
     * @return mixed
     */
    public function unpublish()
    {
        $options = [
            'recordID' => $this->recordID,
            'publish' => 'false',
        ];
        return $this->client->get('publishRecordings', $options);
    }

    /**
     * Delete recording.
     *
     * @return mixed
     */
    public function delete()
    {
        $options = [
            'recordID' => $this->recordID,
        ];
        return $this->client->get('deleteRecordings', $options);
    }
}
