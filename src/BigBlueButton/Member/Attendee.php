<?php

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

    /**
     * Get User ID.
     *
     * @return string
     */
    public function getUserID()
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
}
