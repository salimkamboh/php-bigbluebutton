<?php

/**
 * @file
 * Contains sanduhrs\BigBlueButton\Attendee.
 */

namespace sanduhrs\BigBlueButton;

/**
 * Class Attendee
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
    public $userID;

    /**
     * The full user name.
     *
     * @var string
     */
    public $fullName;

    /**
     * The user role.
     *
     * @var string
     */
    public $role;

    /**
     * Custom user data.
     *
     * @var array
     */
    public $customdata;

    /**
     * Attendee constructor.
     *
     * @param string $userID
     * @param string $fullName
     * @param string $role
     * @param array $customdata
     */
    public function __construct(
        $userID,
        $fullName,
        $role,
        $customdata = []
    ) {
        $this->userID = $userID;
        $this->fullName = $fullName;
        $this->role = $role;
        $this->customdata = $customdata;
    }
}
