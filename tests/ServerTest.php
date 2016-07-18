<?php

namespace sanduhrs\bigbluebutton\tests;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use sanduhrs\BigBlueButton\Server;
use sanduhrs\BigBlueButton\Client;
use Ramsey\Uuid\Uuid;

class ServerTest extends TestCase
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
     * ServerTest constructor.
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

    public function testHasClient()
    {
        $this->assertObjectHasAttribute('client', $this->server);
    }

    public function testCanGetVersion()
    {
        $version = $this->server->getVersion();
        $this->assertNotEmpty($version);
    }

    public function testCanAddMeeting()
    {
        $meeting = $this->server->addMeeting([
          'meetingID' => $this->generateMeetingId(),
        ]);
        $meeting_id = $meeting->getMeetingID();
        $this->assertNotEmpty($meeting_id);
    }

    public function testCanGetMeeting()
    {
        $meeting_1 = $this->server->addMeeting([
          'meetingID' => $this->generateMeetingId(),
        ]);
        $meeting_id_1 = $meeting_1->getMeetingID();

        $meeting_2 = $this->server->getMeeting($meeting_id_1);
        $meeting_id_2 = $meeting_2->getMeetingID();
        $this->assertNotEmpty($meeting_id_2);
    }

    public function testCanGetMeetings()
    {
        // Create a handful of meetings.
        $j = 3;
        for ($i = 0; $i < $j; $i++) {
            $this->server->addMeeting([
              'meetingID' => $this->generateMeetingId(),
            ]);
        }

        $meetings = $this->server->getMeetings();
        $this->assertGreaterThan($j, count($meetings));
    }

    // TODO: Implement methods for default config xml.
    //public function testCanGetDefaultConfigXml() {}
    //public function testCanSetDefaultConfigXml() {}

    // TODO: Implement methods for recordings.
    //public function testCanGetRecording() {}
    //public function testCanGetRecordings() {}
    //public function testCanPublishRecording() {}
    //public function testCanPublishRecordings() {}
    //public function testCanUnPublishRecording() {}
    //public function testCanUnPublishRecordings() {}
    //public function testCanDeleteRecording() {}
    //public function testCanDeleteRecordings() {}
}
