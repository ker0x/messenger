<?php
namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\RequestThreadControl;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class RequestThreadControlTest extends AbstractTestCase
{
    /**
     * @var \Kerox\Messenger\Model\Callback\RequestThreadControl
     */
    protected $requestThreadControl;

    public function setUp()
    {
        $json = file_get_contents(__DIR__ . '/../../../Mocks/Event/request_thread_control.json');
        $array = json_decode($json, true);

        $this->requestThreadControl = RequestThreadControl::create($array['request_thread_control']);
    }

    public function testRequestThreadControlCallback()
    {
        $this->assertEquals('123456789', $this->requestThreadControl->getRequestedOwnerAppId());
        $this->assertEquals('additional content that the caller wants to set', $this->requestThreadControl->getMetadata());
    }

    public function tearDown()
    {
        unset($this->requestThreadControl);
    }
}
