<?php

namespace sanduhrs\BigBlueButton\Member;

use sanduhrs\BigBlueButton\Client;

/**
 * Class Recording.
 *
 * @package sanduhrs\BigBlueButton
 */
class Recording
{
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
     * @var string
     */
    protected $state;

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
     * The BigBlueButton client.
     *
     * @var \sanduhrs\BigBlueButton\Client
     */
    protected $client;

    /**
     * Recording constructor.
     *
     * @param array $options
     */
    public function __construct($options) {
        $options += [
            'recordID' => '',
            'meetingID' => '',
            'name' => '',
            'published' => '',
            'state' => '',
            'startTime' => '',
            'endTime' => '',
            'metadata' => [],
            'playback' => [],
        ];

        foreach ($options as $key => $value) {
            if(isset($this->{$key})) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * Get Record ID.
     *
     * @return string
     */
    public function getRecordID()
    {
        return $this->recordID;
    }

    /**
     * Get Meeting ID.
     *
     * @return string
     */
    public function getMeetingID()
    {
        return $this->meetingID;
    }

    /**
     * Get Name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Check if Recording is published.
     *
     * @return boolean
     */
    public function isPublished()
    {
        return $this->published;
    }

    /**
     * Get Start Time.
     *
     * @return int
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Get End Time.
     *
     * @return int
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Get Metadata.
     *
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Get Playback.
     *
     * @return array
     */
    public function getPlayback()
    {
        return $this->playback;
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
        return $this->client->get('publishRecordings', $options);
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
