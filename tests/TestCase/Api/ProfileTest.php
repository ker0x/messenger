<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Api;

use Kerox\Messenger\Api\Profile;
use Kerox\Messenger\Exception\MessengerException;
use Kerox\Messenger\Model\ProfileSettings;
use Kerox\Messenger\Model\ProfileSettings\Greeting;
use Kerox\Messenger\Test\TestCase\ResourceTestCase;

/**
 * Class ProfileTest
 *
 * @property Profile $resource
 */
class ProfileTest extends ResourceTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $mockedResponse = $this->createMockedResponse(__DIR__ . '/../../Mocks/Response/Profile/add.json');
        $this->mockHandler->append($mockedResponse);

        $this->resource = new Profile($this->client);
    }

    public function testAddSetting(): void
    {
        $profileSettings = new ProfileSettings();
        $profileSettings->addGreetings([
            new Greeting('Hello!'),
        ]);

        $response = $this->resource->add($profileSettings);

        $this->assertSame('success', $response->getResult());
    }

    public function testGetSettings(): void
    {
        $response = $this->resource->get(['greeting', 'get_started']);

        $this->assertSame('success', $response->getResult());
    }

    public function testDeleteSetting(): void
    {
        $this->resource->delete(['greeting', 'get_started']);

        $this->doesNotPerformAssertions();
    }

    public function testBadField(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('menu is not a valid value. fields must only contain "persistent_menu, get_started, greeting, whitelisted_domains, account_linking_url, payment_settings, target_audience".');
        $this->resource->delete(['menu']);
    }
}
