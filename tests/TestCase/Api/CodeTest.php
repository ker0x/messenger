<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase;

use Kerox\Messenger\Api\Code;
use Kerox\Messenger\Exception\MessengerException;

/**
 * Class CodeTest
 *
 * @property Code $resource
 */
class CodeTest extends ResourceTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $mockedResponse = $this->createMockedResponse(__DIR__ . '/../../Mocks/Response/Code/code.json');
        $this->mockHandler->append($mockedResponse);

        $this->resource = new Code($this->client);
    }

    public function testRequestCode(): void
    {
        $response = $this->resource->request(500, 'standard', 'BQCp:J7F._fImVNMkIBpwN+gZfO_9-BNcB:mi licpWD/y9VS=3niM.uFpZ=OR.mmsKSG 0T_d7949R/Y 9xsIuxyzI5U+QozJ-iz0gU38Qf6-xEueGOIrxbOwbH-MR11mByfU/Q.cTA044QdqJaoerjjY-L+L.lYycB4Cv:7 oSUKY3xqrGTYpNu:bfp9+JoNHuQ9gz 0l7R-3994-o7lIq=09IhXFeF.27v9RJXZG.7p/bnSmDSn1G+');

        $this->assertSame('https://scontent.xx.fbcdn.net/v/t39.8917-6/16685555_1672240442792330_5569294125766803456_n.png?oh=eb8cf65a7a7a5808b24e55527b366dd0&oe=592BBFCC', $response->getUri());
    }

    public function testSmallImageSize(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('imageSize must be between 100 and 2000.');
        $this->resource->request(99, 'standard');
    }

    public function testBigImageSize(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('imageSize must be between 100 and 2000.');
        $this->resource->request(2001, 'standard');
    }

    public function testBadCodeType(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('codeType must be either "standard".');
        $this->resource->request(2000, 'stretch');
    }

    public function testInvalidRef(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('ref must be a string of max 250 characters. Valid characters are "a-z A-Z 0-9 +/=-.:_".');
        $this->resource->request(1000, 'standard', 'eA.2fL0-4fxK.jSpw@6ud6-=U7y=AMMiEvxK CsP\rLH:F4bUl:5bLC\p=dnytfBpHMTVrXyQ20B=O4h2S_8UGog5ruzzFwd/Ytg0I/HTg8N86WC@R591z5t0MB//ZQvsB4aKX0MIELCqr96=/+lfPqL+q1fAKBxbc+FV+l/@d35Znf+OfSOIUydXTa+YmI1hJVf38FA3L 96zn.RqB+s.:-/_:0-YMJM2jBthlwz0pg5y5y mQ=Rhho0.');
    }
}
