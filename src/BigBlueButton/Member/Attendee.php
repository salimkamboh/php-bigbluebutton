<?php

namespace sanduhrs\BigBlueButton\Member;

use sanduhrs\BigBlueButton\Client;

/**
 * Class Attendee.
 *
 * @package sanduhrs\BigBlueButton
 */
class Attendee
{
    /**
     * The user ID.
     *
     * @var string
     */
    protected $userID;

    /**
     * The full user name.
     *
     * @var string
     */
    protected $fullName;

    /**
     * The user role.
     *
     * @var string
     */
    protected $role;

    /**
     * Custom user data.
     *
     * @var array
     */
    protected $customdata;

    /**
     * Attendee is a presenter.
     *
     * @var bool
     */
    protected $isPresenter;

    /**
     * Attendee is listening only.
     *
     * @var bool
     */
    protected $isListeningOnly;

    /**
     * Attendee has joined with voice.
     *
     * @var bool
     */
    protected $hasJoinedVoice;

    /**
     * Attendee has joined with video.
     *
     * @var bool
     */
    protected $hasVideo;

    /**
     * The BigBlueButton client.
     *
     * @var \sanduhrs\BigBlueButton\Client
     */
    protected $client;

    /**
     * Attendee constructor.
     *
     * @param array $attributes
     *   - userID
     *   - fullName
     *   - role
     *   - customdata
     */
    public function __construct($attributes)
    {
        foreach ($attributes as $key => $value) {
            if (property_exists(self::class, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * Alias for getUserId().
     * @return string
     */
    public function getId()
    {
        return $this->getUserId();
    }

    /**
     * Get User ID.
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->userID;
    }

    /**
     * Get Full Name.
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Get Role.
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Get Custom Data.
     *
     * @return array
     */
    public function getCustomdata()
    {
        return $this->customdata;
    }

    /**
     * @return bool
     */
    public function isPresenter()
    {
        return $this->isPresenter;
    }

    /**
     * @return bool
     */
    public function isListeningOnly()
    {
        return $this->isListeningOnly;
    }

    /**
     * @return bool
     */
    public function hasJoinedVoice()
    {
        return $this->hasJoinedVoice;
    }

    /**
     * @return bool
     */
    public function hasVideo()
    {
        return $this->hasVideo;
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
