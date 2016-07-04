<?php

/**
 * @file
 * Contains sanduhrs\BigBlueButton\Meeting.
 */

namespace sanduhrs\BigBlueButton;

use sanduhrs\BigBlueButton\Attendee;
use sanduhrs\BigBlueButton\Client;
use sanduhrs\BigBlueButton\Recording;

/**
 * Class Meeting
 *
 * @package sanduhrs\BigBlueButton
 */
class Meeting
{
    /**
     * The BigBlueButton client.
     *
     * @var \sanduhrs\BigBlueButton\Client
     */
    protected $client;

    /**
     * The meeting ID.
     *
     * A meeting ID that can be used to identify this meeting by the 3rd-party
     * application.
     *
     * @var string
     */
    protected $meetingID;

    /**
     * The attendee password.
     *
     * The password that will be required for attendees to join the meeting.
     *
     * @var string
     */
    protected $attendeePW;

    /**
     * The moderator password.
     *
     * The password that will be required for moderators to join the meeting or
     * for certain administrative actions (i.e. ending a meeting).
     *
     * @var string
     */
    protected $moderatorPW;

    /**
     * @var integer
     */
    protected $createTime;

    /**
     * @var string
     */
    protected $createDate;

    /**
     * @var boolean
     */
    protected $hasUserJoined;

    /**
     * @var integer
     */
    protected $duration;

    /**
     * @var boolean
     */
    protected $hasBeenForciblyEnded;

    /**
     * @var string
     */
    protected $meetingName;

    /**
     * @var string
     */
    protected $voiceBridge;

    /**
     * @var string
     */
    protected $dialNumber;

    /**
     * @var boolean
     */
    protected $running;

    /**
     * @var boolean
     */
    protected $recording;

    /**
     * @var integer
     */
    protected $startTime;

    /**
     * @var string
     */
    protected $endTime;

    /**
     * @var integer
     */
    protected $participantCount;

    /**
     * @var integer
     */
    protected $maxUsers;

    /**
     * @var integer
     */
    protected $moderatorCount;

    /**
     * @var integer
     */
    protected $attendees;

    /**
     * @var array
     */
    protected $metadata;

    /**
     * @var array
     *   An array of \sanduhrs\BigBlueButton\Recording
     */
    protected $recordings;

    /**
     * Meeting constructor.
     *
     * @param string $meetingID
     * @param string $attendeePW
     * @param string $moderatorPW
     * @param array $options
     * @param \sanduhrs\BigBlueButton\Client $client
     */
    public function __construct(
        $meetingID,
        $attendeePW,
        $moderatorPW,
        $options,
        $client
    ) {
        $this->meetingID = $meetingID;
        $this->attendeePW = $attendeePW;
        $this->moderatorPW = $moderatorPW;
        $this->client = $client;
        $this->createTime = 0;
        $this->createDate = '';
        $this->hasUserJoined = null;
        $this->duration = 0;
        $this->hasBeenForciblyEnded = null;
        $this->meetingName = '';
        $this->voiceBridge = '';
        $this->dialNumber = '';
        $this->running = null;
        $this->recording = null;
        $this->startTime = 0;
        $this->endTime = '';
        $this->participantCount = 0;
        $this->maxUsers = 0;
        $this->moderatorCount = 0;
        $this->attendees =  [];
        $this->metadata = [];
        $this->recordings = [];
        if (isset($options['createTime'])) {
            $this->createTime = $options['createTime'];
        }
        if (isset($options['createDate'])) {
            $this->createDate = $options['createDate'];
        }
        if (isset($options['hasUserJoined'])) {
            $this->hasUserJoined = $options['hasUserJoined'];
        }
        if (isset($options['duration'])) {
            $this->duration = $options['duration'];
        }
        if (isset($options['hasBeenForciblyEnded'])) {
            $this->hasBeenForciblyEnded = $options['hasBeenForciblyEnded'];
        }
        if (isset($options['name'])) {
            $this->meetingName = $options['name'];
        }
        if (isset($options['voiceBridge'])) {
            $this->voiceBridge = $options['voiceBridge'];
        }
        if (isset($options['dialNumber'])) {
            $this->dialNumber = $options['dialNumber'];
        }
        if (isset($options['running'])) {
            $this->running = $options['running'];
        }
        if (isset($options['recording'])) {
            $this->recording = $options['recording'];
        }
        if (isset($options['startTime'])) {
            $this->startTime = $options['startTime'];
        }
        if (isset($options['endTime'])) {
            $this->endTime = $options['endTime'];
        }
        if (isset($options['participantCount'])) {
            $this->participantCount = $options['participantCount'];
        }
        if (isset($options['maxUsers'])) {
            $this->maxUsers = $options['maxUsers'];
        }
        if (isset($options['moderatorCount'])) {
            $this->moderatorCount = $options['moderatorCount'];
        }
        if (isset($options['attendees'])) {
            $this->attendees = $options['attendees'];
        }
        if (isset($options['metadata'])) {
            $this->metadata = (array) $options['metadata'];
        }
    }

    /**
     * Create meeting.
     *
     * Creates a BigBlueButton meeting.
     * The create call is idempotent: you can call it multiple times with the same
     * parameters without side effects. This simplifies the logic for joining a
     * user into a session, your application can always call create before
     * returning the join URL. This way, regardless of the order in which users
     * join, the meeting will always exist but won’t be empty. The BigBlueButton
     * server will automatically remove empty meetings that were created but have
     * never had any users after a number of minutes specified by
     * defaultMeetingCreateJoinDurationdefined in bigbluebutton.properties.
     *
     * @param array $options
     *   - name (string): A name for the meeting.
     *   - welcome (string): A welcome message that gets displayed on the chat
     *     window when the participant joins. You can include keywords
     *     (%%CONFNAME%%, %%DIALNUM%%, %%CONFNUM%%) which will be substituted
     *     automatically. You can set a default welcome message on
     *     bigbluebutton.properties
     *   - dialNumber (string): The dial access number that participants can call
     *     in using regular phone. You can set a default dial number on
     *     bigbluebutton.properties
     *   - voiceBridge (string): Voice conference number that participants enter
     *     to join the voice conference. The default pattern for this is a 5-digit
     *     number. This is the PIN that a dial-in user must enter to join the
     *     conference. If you want to change this pattern, you have to edit
     *     FreeSWITCH dialplan and defaultNumDigitsForTelVoice of
     *     bigbluebutton.properties. When using the default setup, we recommend
     *     you always pass a 5-digit voiceBridge parameter. Finally, if you don’t
     *     pass a value for voiceBridge, then users will not be able to join a
     *     voice conference for the session.
     *   - webVoice (string): Voice conference alphanumberic that participants
     *     enter to join the voice conference.
     *   - logoutURL (string): The URL that the BigBlueButton client will go to
     *     after users click the OK button on the ‘You have been logged out
     *     message’. This overrides, the value for bigbluebutton.web.loggedOutURL
     *     if defined in bigbluebutton.properties
     *   - record (boolean): Setting ‘record=true’ instructs the BigBlueButton
     *     server to record the media and events in the session for later
     *     playback. Available values are true or false. Default value is false.
     *   - duration (number): The maximum length (in minutes) for the meeting.
     *     Normally, the BigBlueButton server will end the meeting when either the
     *     last person leaves (it takes a minute or two for the server to clear
     *     the meeting from memory) or when the server receives an end API request
     *     with the associated meetingID (everyone is kicked and the meeting is
     *     immediately cleared from memory). BigBlueButton begins tracking the
     *     length of a meeting when the first person joins. If duration contains a
     *     non-zero value, then when the length of the meeting exceeds the
     *     duration value the server will immediately end the meeting (same as
     *     receiving an end API request).
     *   - meta (string): You can pass one or more metadata values for create a
     *     meeting. These will be stored by BigBlueButton and later retrievable
     *     via the getMeetingInfo call and getRecordings. Examples of meta
     *     parameters are meta_Presenter, meta_category, meta_LABEL, etc. All
     *     parameters are converted to lower case, so meta_Presenter would be the
     *     same as meta_PRESENTER.
     *   - moderatorOnlyMessage (string): Display a message to all moderators in
     *     the public chat.
     *   - autoStartRecording (boolean): Automatically starts recording when first
     *     user joins. NOTE: Don’t set to autoStartRecording =false and
     *     allowStartStopRecording=false as the user won’t be able to record.
     *   - allowStartStopRecording (boolean): Allow the user to start/stop
     *     recording. This means the meeting can start recording automatically
     *     (autoStartRecording=true) with the user able to stop/start recording
     *     from the client.
     *
     * @return string
     *   The xml formatted server response string.
     *
     * @todo http://docs.bigbluebutton.org/dev/api.html#preupload-slides
     */
    public function create($options = [])
    {
        $options += [
            'meetingID' => $this->meetingID,
            'attendeePW' => $this->attendeePW,
            'moderatorPW' => $this->moderatorPW,
        ];
        $response = $this->client->get('create', $options);
        return new Meeting(
            $response->meetingID,
            $response->attendeePW,
            $response->moderatorPW,
            (array) $response,
            $this->client
        );
    }

    /**
     * Join meeting.
     *
     * Joins a user to the meeting.
     *
     * @param string $fullName
     *   The full name that is to be used to identify this user to other
     *   conference attendees.
     * @param array $options
     *   - createTime (string): Third-party apps using the API can now pass
     *     createTime parameter (which was created in the create call),
     *     BigBlueButton will ensure it matches the ‘createTime’ for the session.
     *     If they differ, BigBlueButton will not proceed with the join request.
     *     This prevents a user from reusing their join URL for a subsequent
     *     session with the same meetingID.
     *   - userID (string): An identifier for this user that will help your
     *     application to identify which person this is. This user ID will be
     *     returned for this user in the getMeetingInfo API call so that you can
     *     check.
     *   - webVoiceConf (string): If you want to pass in a custom voice-extension
     *     when a user joins the voice conference using voip. This is useful if
     *     you want to collect more info in you Call Detail Records about the user
     *     joining the conference. You need to modify your
     *     /etc/asterisk/bbb-extensions.conf to handle this new extensions.
     *   - configToken (string): The token returned by a setConfigXML API call.
     *     This causes the BigBlueButton client to load the config.xml associated
     *     with the token (not the default config.xml)
     *   - avatarURL (string): The link for the user’s avatar to be displayed when
     *     displayAvatar in config.xml is set to true.
     *   - redirect (string): The default behaviour of the JOIN API is to redirect
     *     the browser to the Flash client when the JOIN call succeeds. There have
     *     been requests if it’s possible to embed the Flash client in a
     *     “container” page and that the client starts as a hidden DIV tag which
     *     becomes visible on the successful JOIN. Setting this variable to FALSE
     *     will not redirect the browser but returns an XML instead whether the
     *     JOIN call has succeeded or not. The third party app is responsible for
     *     displaying the client to the user.
     *   - clientURL (string): Some third party apps what to display their own
     *     custom client. These apps can pass the URL containing the custom client
     *     and when redirect is not set to false, the browser will get redirected
     *     to the value of clientURL.
     *
     * @return string
     *   The meeting join URL to redirect to.
     */
    public function join($fullName, $moderator = false, $options = [])
    {
        $options += [
            'fullName' => $fullName,
            'meetingID' => $this->meetingID,
            'password' => $moderator ? $this->moderatorPW : $this->attendeePW,
        ];
        $url = $this->client->generateURL('join', $options);
        return $url;
    }

    /**
     * Check meeting status.
     *
     * This call enables you to simply check on whether or not a meeting is
     * running by looking it up with your meeting ID.
     *
     * @return boolean
     *   The running status of the meeting TRUE for running.
     */
    public function isRunning()
    {
        $options = [
            'meetingID' => $this->meetingID,
        ];
        $response = $this->client->get('isMeetingRunning', $options);
        return $response->running === 'true';
    }

    /**
     * End Meeting.
     *
     * Use this to forcibly end a meeting and kick all participants out of the
     * meeting.
     *
     * @return boolean
     *   The boolean TRUE if the end request has been sent.
     */
    public function end()
    {
        $options = [
            'meetingID' => $this->meetingID,
            'password' => $this->moderatorPW,
        ];
        $this->client->get('end', $options);
        return true;
    }

    /**
     * Get Meeting Info
     *
     * This call will return all of a meeting’s information, including the list of
     * attendees as well as start and end times.
     *
     * @return \sanduhrs\BigBlueButton\Meeting
     *   The meeting object.
     */
    public function getInfo()
    {
        $options = [
            'meetingID' => $this->meetingID,
            'password' => $this->moderatorPW,
        ];
        $info = $this->client->get('getMeetingInfo', $options);
        foreach ($info as $key => $value) {
            if (isset($this->{$key})) {
                if ($key === 'attendees') {
                    foreach ($value as $attendee) {
                        $this->{$key}[$attendee->userID] = new Attendee(
                            (string) $attendee->userID,
                            (string) $attendee->fullName,
                            (string) $attendee->role,
                            isset($attendee->customData) ? (array) $attendee->customData : []
                        );
                    }
                } else {
                    $this->{$key} = $value;
                }
            }
        }
        return $this;
    }

    /**
     * Get recording.
     *
     * Retrieves a recording that is available for playback.
     *
     * @param string $recordingID
     *   The recording ID.
     *
     * @return \sanduhrs\BigBlueButton\Recording|FALSE
     *   An recording object or FALSE.
     */
    public function getRecording($recordingID)
    {
        $recordings = $this->getRecordings();
        if (isset($recordings[$recordingID])) {
            return $recordings[$recordingID];
        }
        return false;
    }

    /**
     * Get recordings.
     *
     * Retrieves the recordings that are available for playback.
     *
     * @return array
     *   An array of \sanduhrs\BigBlueButton\Recording.
     */
    public function getRecordings()
    {
        $options = [
            'meetingID' => $this->meetingID,
        ];
        $response = $this->client->get('getRecordings', $options);

        $recordings = [];
        if (isset($response->recordings->recording) &&
            is_object($response->recordings->recording)) {
            $recordings[] = $response->recordings->recording;
        } elseif (isset($response->recordings->recording)) {
            $recordings = $response->recordings->recording;
        }
        foreach ($recordings as $recording) {
            $this->recordings[$recording->recordingID] = new Recording(
                $recording->recordingID,
                (array) $recording,
                $this->client
            );
        }
        return $this->recordings;
    }

    /**
     * Publish recording.
     *
     * Publish a recording for a given recordID.
     *
     * @param string $recordID
     *   A record ID to apply the publish action to.
     *
     * @return boolean
     *   The success status as TRUE.
     */
    public function publishRecording($recordID)
    {
        return $this->publishRecordings([$recordID]);
    }

    /**
     * Publish recordings.
     *
     * Publish recordings for a set of record IDs.
     *
     * @param array $recordIDs
     *   A set of record IDs to apply the publish action to.
     *
     * @return boolean
     *   The success status as TRUE.
     */
    public function publishRecordings($recordIDs)
    {
        $options = [
            'recordID' => implode(',', $recordIDs),
            'publish' => 'true',
        ];
        $this->client->get('publishRecordings', $options);
        return true;
    }

    /**
     * Delete recording.
     *
     * Delete a recording for a given recordID.
     *
     * @param string $recordID
     *   A record ID to apply the delete action to.
     *
     * @return boolean
     *   The success status as TRUE.
     */
    public function deleteRecording($recordID)
    {
        return $this->deleteRecordings([$recordID]);
    }

    /**
     * Delete recordings.
     *
     * Delete recordings for a set of record IDs.
     *
     * @param array $recordIDs
     *   A set of record IDs to apply the delete action to.
     *
     * @return boolean
     *   The success status as TRUE.
     */
    public function deleteRecordings($recordIDs)
    {
        $options = [
            'recordID' => implode(',', $recordIDs),
        ];
        $this->client->get('deleteRecordings', $options);
        return true;
    }

    /**
     * Set config xml.
     *
     * Associate a custom config.xml file with the current session. This call
     * returns a token that can later be passed as a parameter to a join URL. When
     * passed as a parameter, the BigBlueButton client will use the associated
     * config.xml for the user instead of using the default config.xml. This
     * enables 3rd party applications to provide user-specific config.xml files.
     *
     * @return string
     *   The xml formatted server response string.
     */
    public function setConfigXML($configXML)
    {
        $options = [
            'meetingID' => $this->meetingID,
            'configXML' => $configXML,
        ];
        $this->client->postRaw('setConfigXML', $options);
        return true;
    }
}
