<?php

declare(strict_types=1);

namespace Kerox\Messenger\Http;

use Psr\Http\Client\ClientExceptionInterface;

class ClientException extends \GuzzleHttp\Exception\ClientException implements ClientExceptionInterface
{
}
