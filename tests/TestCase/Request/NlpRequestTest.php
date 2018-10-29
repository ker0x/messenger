<?php

namespace Kerox\Messenger\Test\TestCase\Request;

use Kerox\Messenger\Request\NlpRequest;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class NlpRequestTest extends AbstractTestCase
{
    public function testBuild()
    {
        $config = [
            'nlp_enabled' => true,
            'model' => 'ENGLISH',
            'custom_token' => '$CUSTOM_TOKEN',
            'verbose' => true,
            'n_best' => 2,
        ];

        $request = new NlpRequest('me/nlp_configs', $config);
        $origin = $request->build();

        $expected = http_build_query($config);

        $this->assertSame('POST', $origin->getMethod());
        $this->assertSame('me/nlp_configs', $origin->getUri()->getPath());
        $this->assertSame($expected, $origin->getUri()->getQuery());
    }
}
