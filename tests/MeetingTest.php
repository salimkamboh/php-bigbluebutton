<?php

namespace sanduhrs\BigBlueButton\tests;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use sanduhrs\BigBlueButton\Server;
use sanduhrs\BigBlueButton\Client;
use sanduhrs\BigBlueButton\Member\Meeting;

class MeetingTest extends TestCase
{

    /**
     * The server uri.
     *
     * @var \GuzzleHttp\Psr7\Uri
     */
    protected $uri;

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
     * The server.
     *
     * @var \sanduhrs\BigBlueButton\Server
     */
    protected $server;

    /**
     * The client.
     *
     * @var \sanduhrs\BigBlueButton\Client
     */
    protected $client;

    /**
     * The meeting.
     *
     * @var \sanduhrs\BigBlueButton\Member\Meeting
     */
    protected $meeting;

    /**
     * MeetingTest constructor.
     *
     * @param null|string $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->uri = new Uri(getenv('BBB_URI'));
        $this->secret = getenv('BBB_SECRET');
        $this->endpoint = getenv('BBB_ENDPOINT');

        $this->client = new Client(
            $this->uri,
            $this->secret,
            $this->endpoint
        );

        $this->server = new Server(
            $this->client
        );
    }

    /**
     * Generate new unique meeting id.
     *
     * @return string
     */
    private function generateMeetingId()
    {
        $uuid4 = Uuid::uuid4();
        return $uuid4->toString();
    }

    /**
     * Create a meeting.
     *
     * @return \sanduhrs\BigBlueButton\Member\Meeting
     */
    private function createMeeting($attributes = [])
    {
        $attributes += [
          'id' => $this->generateMeetingId(),
        ];

        $meeting = new Meeting(
            $attributes,
            $this->client
        );
        $meeting->create();
        return $meeting;
    }

    public function testHasClient()
    {
        $this->assertObjectHasAttribute('client', $this);
    }

    public function testCanCreateMeeting()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('meetingID', $meeting);
    }

    public function testCanJoinMeetingAsAttendee()
    {
        $meeting = $this->createMeeting();
        $uri = $meeting->join('Username', false);
        $valid = (bool) filter_var($uri, FILTER_VALIDATE_URL);
        $this->assertTrue($valid);
    }

    public function testCanJoinMeetingAsModerator()
    {
        $meeting = $this->createMeeting();
        $uri = $meeting->join('Username', true);
        $valid = (boolean) filter_var($uri, FILTER_VALIDATE_URL);
        $this->assertTrue($valid);
    }

    public function testCanCheckIfMeetingIsRunning()
    {
        $meeting = $this->createMeeting();
        $is_running = $meeting->isRunning();
        $this->assertFalse($is_running);
    }

    public function testCanEndMeeting()
    {
        $meeting = $this->createMeeting();
        $end = $meeting->end();
        $this->assertTRUE($end);
    }

    public function testHasMeetingName()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('meetingName', $meeting);
    }

    public function testHasMeetingID()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('meetingID', $meeting);
    }

    public function testHasAttendeePW()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('attendeePW', $meeting);
    }

    public function testHasModeratorPW()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('moderatorPW', $meeting);
    }

    public function testHasWelcome()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('welcome', $meeting);
    }

    public function testHasDialNumber()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('dialNumber', $meeting);
    }

    public function testHasVoiceBridge()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('voiceBridge', $meeting);
    }

    public function testHasWebVoice()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('webVoice', $meeting);
    }

    public function testHasLogoutURL()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('logoutURL', $meeting);
    }

    public function testHasRecord()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('record', $meeting);
    }

    public function testHasDuration()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('duration', $meeting);
    }

    public function testHasMetadata()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('metadata', $meeting);
    }

    public function testHasModeratorOnlyMessage()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('moderatorOnlyMessage', $meeting);
    }

    public function testHasAutoStartRecording()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('autoStartRecording', $meeting);
    }

    public function testHasAllowStartStopRecording()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('allowStartStopRecording', $meeting);
    }

    public function testHasCreateTime()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('createTime', $meeting);
    }

    public function testHasCreateDate()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('createDate', $meeting);
    }

    public function testHasRunning()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('running', $meeting);
    }

    public function testHasUserJoined()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('hasUserJoined', $meeting);
    }

    public function testHasRecording()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('recording', $meeting);
    }

    public function testHasHasBeenForciblyEnded()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('hasBeenForciblyEnded', $meeting);
    }

    public function testHasStartTime()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('startTime', $meeting);
    }

    public function testHasEndTime()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('endTime', $meeting);
    }

    public function testHasParticipantCount()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('participantCount', $meeting);
    }

    public function testHasVideoCount()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('videoCount', $meeting);
    }

    public function testHasMaxUsers()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('maxUsers', $meeting);
    }

    public function testHasModeratorCount()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('moderatorCount', $meeting);
    }

    public function testHasAttendees()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('attendees', $meeting);
    }

    public function testHasRecordings()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('recordings', $meeting);
    }

    public function testHasSlides()
    {
        $meeting = $this->createMeeting();
        $this->assertObjectHasAttribute('slides', $meeting);
    }

    public function testCanGetMeetingName()
    {
        $name = 'name';
        $value = 'The meeting name';
        $meeting = $this->createMeeting([
          $name => $value,
        ]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertEquals($value, $attribute);
    }

    public function testCanGetMeetingID()
    {
        $name = 'id';
        $value = $this->generateMeetingId();
        $meeting = $this->createMeeting([
          $name => $value,
        ]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertEquals($value, $attribute);
    }

    public function testCanGetAttendeePW()
    {
        $name = 'attendeePW';
        $value = 'Th1S1sV3ryS3cr3TF0r4tt3nd33S';
        $meeting = $this->createMeeting([
          $name => $value,
        ]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertEquals($value, $attribute);
    }

    public function testCanGetModeratorPW()
    {
        $name = 'moderatorPW';
        $value = 'Th1S1sV3ryS3cr3TF0rM0d3rat0rS';
        $meeting = $this->createMeeting([
          $name => $value,
        ]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertEquals($value, $attribute);
    }

    public function testCanGetWelcome()
    {
        $name = 'welcome';
        $value = 'Hey, welcome!';
        $meeting = $this->createMeeting([
          $name => $value,
        ]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertEquals($value, $attribute);
    }

    public function testCanGetDialNumber()
    {
        $name = 'dialNumber';
        $value = $this->generateMeetingId();
        $meeting = $this->createMeeting([
          $name => $value,
        ]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertEquals($value, $attribute);
    }

    /**
    public function testCanGetVoiceBridge()
    {
        $name = 'voiceBridge';
        $value = $this->generateMeetingId();
        $meeting = $this->createMeeting([
            $name => $value,
        ]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertEquals($value, $attribute);
    }
     */

    public function testCanGetWebVoice()
    {
        $name = 'webVoice';
        $value = $this->generateMeetingId();
        $meeting = $this->createMeeting([
          $name => $value,
        ]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertEquals($value, $attribute);
    }

    public function testCanGetLogoutURL()
    {
        $name = 'logoutURL';
        $value = 'https://example.org/';
        $meeting = $this->createMeeting([
          $name => $value,
        ]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertEquals($value, $attribute);
    }

    public function testCanGetRecord()
    {
        $name = 'record';
        $value = true;
        $meeting = $this->createMeeting([
          $name => $value,
        ]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertEquals($value, $attribute);
    }

    public function testCanGetDuration()
    {
        $name = 'duration';
        $value = 30;
        $meeting = $this->createMeeting([
          $name => $value,
        ]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertEquals($value, $attribute);
    }

    /**
    public function testCanGetMeta()
    {
        $name = 'metadata';
        $value = [
            'presenter' => 'Paul Presenter',
            'category' => 'Food',
            'label' => 'Vegan',
        ];
        $meeting = $this->createMeeting([
            $name => $value,
        ]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertEquals($value, $attribute);
    }
     */

    public function testCanGetModeratorOnlyMessage()
    {
        $name = 'moderatorOnlyMessage';
        $value = 'This is just for you!';
        $meeting = $this->createMeeting([
          $name => $value,
        ]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertEquals($value, $attribute);
    }

    public function testCanGetAutoStartRecording()
    {
        $name = 'autoStartRecording';
        $value = true;
        $meeting = $this->createMeeting([
          $name => $value,
        ]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertEquals($value, $attribute);
    }

    public function testCanGetAllowStartStopRecording()
    {
        $name = 'allowStartStopRecording';
        $value = true;
        $meeting = $this->createMeeting([
          $name => $value,
        ]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertEquals($value, $attribute);
    }

    public function testCanGetCreateTime()
    {
        $name = 'createTime';
        $meeting = $this->createMeeting([]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertNotEmpty($attribute);
    }

    public function testCanGetCreateDate()
    {
        $name = 'createDate';
        $meeting = $this->createMeeting([]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertNotEmpty($attribute);
    }

    public function testCanGetRunning()
    {
        $name = 'running';
        $meeting = $this->createMeeting([]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertFalse($attribute);
    }

    public function testCanGetUserJoined()
    {
        $name = 'running';
        $meeting = $this->createMeeting([]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertFalse($attribute);
    }

    public function testCanGetHasBeenForciblyEnded()
    {
        $name = 'hasBeenForciblyEnded';
        $meeting = $this->createMeeting([]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertFalse($attribute);
    }

    public function testCanGetStartTime()
    {
        $name = 'startTime';
        $meeting = $this->createMeeting([]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertNotEmpty($attribute);
    }

    public function testCanGetEndTime()
    {
        $name = 'endTime';
        $meeting = $this->createMeeting([]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertGreaterThanOrEqual(0, $attribute);
    }

    public function testCanGetParticipantCount()
    {
        $name = 'participantCount';
        $meeting = $this->createMeeting([]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertGreaterThanOrEqual(0, $attribute);
    }

    public function testCanGetVideoCount()
    {
        $name = 'videoCount';
        $meeting = $this->createMeeting([]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertGreaterThanOrEqual(0, $attribute);
    }

    public function testCanGetMaxUsers()
    {
        $name = 'maxUsers';
        $meeting = $this->createMeeting([]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertGreaterThanOrEqual(0, $attribute);
    }

    public function testCanGetModeratorCount()
    {
        $name = 'moderatorCount';
        $meeting = $this->createMeeting([]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertGreaterThanOrEqual(0, $attribute);
    }

    public function testCanGetAttendees()
    {
        $name = 'attendees';
        $meeting = $this->createMeeting([]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertEquals(0, count($attribute));
    }

    public function testCanGetMetadata()
    {
        $name = 'metadata';
        $meeting = $this->createMeeting([]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertEquals(0, count($attribute));
    }

    public function testCanGetSlides()
    {
        $name = 'slides';
        $meeting = $this->createMeeting([]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertEquals(0, count($attribute));
    }

    public function testCanGetRecordings()
    {
        $name = 'recordings';
        $meeting = $this->createMeeting([]);
        $attribute = $meeting->{'get' . ucfirst($name)}();
        $this->assertEquals(0, count($attribute));
    }

    /**
    public function testCanGetRecording() {}
     */

    /**
    public function testCanGetPublishRecording() {}
     */

    /**
    public function testCanGetPublishRecordings() {}
     */

    /**
    public function testCanGetDeleteRecording() {}
     */

    /**
    public function testCanGetDeleteRecordings() {}
     */

    /**
    public function testCanSetConfigXml() {}
     */
}
