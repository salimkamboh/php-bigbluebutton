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
    public $client;

    /**
     * The record id.
     *
     * @var string
     */
    public $recordID;

    /**
     * The meeting id.
     *
     * @var string
     */
    public $meetingID;

    /**
     * The record name.
     *
     * @var string
     */
    public $name;

    /**
     * The published state.
     *
     * @var boolean
     */
    public $published;

    /**
     * The start time.
     *
     * @var integer
     */
    public $startTime;

    /**
     * The end time.
     *
     * @var integer
     */
    public $endTime;

    /**
     * The metadata.
     *
     * @var array
     */
    public $metadata;

    /**
     * The playback data.
     *
     * @var array
     */
    public $playback;

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
        $this->recordID = $recordID;
        $this->client = $client;
        $this->meetingID = '';
        $this->name = '';
        $this->published = null;
        $this->startTime = 0;
        $this->endTime = 0;
        $this->metadata = [];
        $this->playback = [];
        if (isset($options['meetingID'])) {
            $this->meetingID = $options['meetingID'];
        }
        if (isset($options['name'])) {
            $this->name = $options['name'];
        }
        if (isset($options['published'])) {
            $this->published = $options['published'];
        }
        if (isset($options['startTime'])) {
            $this->startTime = $options['startTime'];
        }
        if (isset($options['endTime'])) {
            $this->endTime = $options['endTime'];
        }
        if (isset($options['metadata'])) {
            $this->metadata = $options['metadata'];
        }
        if (isset($options['playback'])) {
            $this->playback = $options['playback'];
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
