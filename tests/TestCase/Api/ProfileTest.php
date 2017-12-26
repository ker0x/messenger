<?php
namespace Kerox\Messenger\Test\TestCase\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Api\Profile;
use Kerox\Messenger\Model\ProfileSettings;
use Kerox\Messenger\Model\ProfileSettings\Greeting;
use Kerox\Messenger\Response\ProfileResponse;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class ProfileTest extends AbstractTestCase
{

    /**
     * @var \Kerox\Messenger\Api\Profile
     */
    protected $profileApi;

    public function setUp()
    {
        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/Profile/add.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler
        ]);

        $this->profileApi = new Profile('abcd1234', $client);
    }

    public function testAddSetting()
    {
        $profileSettings = new ProfileSettings();
        $profileSettings->addGreetings([
            new Greeting('Hello!')
        ]);

        $response = $this->profileApi->add($profileSettings);

        $this->assertInstanceOf(ProfileResponse::class, $response);
        $this->assertEquals('success', $response->getResult());
    }

    public function testGetSettings()
    {
        $response = $this->profileApi->get(['greeting', 'get_started']);

        $this->assertInstanceOf(ProfileResponse::class, $response);
        $this->assertEquals('success', $response->getResult());
    }

    public function testDeleteSetting()
    {
        $this->profileApi->delete(['greeting', 'get_started']);

        $this->doesNotPerformAssertions();
    }

    public function testBadField()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('menu is not a valid value. $fields must only contain persistent_menu, get_started, greeting, whitelisted_domains, account_linking_url, payment_settings, target_audience');
        $this->profileApi->delete(['menu']);
    }

    public function tearDown()
    {
        unset($this->profileApi);
    }
}