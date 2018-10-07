<?php

namespace Kerox\Messenger\Http;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;

class Middleware
{
    /**
     * Append 'Content-Type' header to each client request.
     *
     * @param string $contentType
     *
     * @return callable
     */
    public static function contentTypeHeader(string $contentType): callable
    {
        return \GuzzleHttp\Middleware::mapRequest(function (RequestInterface $request) use ($contentType) {
            return $request->withHeader('Content-Type', $contentType);
        });
    }

    /**
     * Append query param to each client request.
     *
     * @param string $name
     * @param string $value
     *
     * @return callable
     */
    public static function queryParam(string $name, string $value): callable
    {
        return \GuzzleHttp\Middleware::mapRequest(function (RequestInterface $request) use ($name, $value) {
            $uri = Uri::withQueryValue($request->getUri(), $name, $value);
            return $request->withUri($uri);
        });
    }
}
