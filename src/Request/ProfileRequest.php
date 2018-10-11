<?php

declare(strict_types=1);

namespace Kerox\Messenger\Request;

use GuzzleHttp\Psr7\Uri;
use Kerox\Messenger\Model\ProfileSettings;
use Psr\Http\Message\RequestInterface;
use function GuzzleHttp\Psr7\stream_for;

class ProfileRequest extends AbstractRequest implements QueryRequestInterface, BodyRequestInterface
{
    /**
     * @var mixed
     */
    protected $profileSettings;

    /**
     * ProfileRequest constructor.
     *
     * @param string $path
     * @param mixed  $profileSettings
     */
    public function __construct(string $path, $profileSettings)
    {
        parent::__construct($path);

        $this->profileSettings = $profileSettings;
    }

    /**
     * @param string|null $method
     *
     * @return RequestInterface
     */
    public function build(?string $method = null): RequestInterface
    {
        $request = $this->origin->withMethod($method);

        if ($method === 'get') {
            $uri = Uri::fromParts([
                'query' => $this->buildQuery(),
            ]);

            return $request->withUri($uri);
        }

        return $request->withBody(stream_for($this->buildBody()));
    }

    /**
     * @return string
     */
    public function buildBody(): string
    {
        $body = [];
        if ($this->profileSettings instanceof ProfileSettings) {
            $body = $this->profileSettings;
        } elseif (\is_array($this->profileSettings)) {
            $body = [
                'fields' => $this->profileSettings,
            ];
        }

        return json_encode($body);
    }

    /**
     * @return string
     */
    public function buildQuery(): string
    {
        if (\is_string($this->profileSettings)) {
            return http_build_query([
                'fields' => $this->profileSettings,
            ]);
        }

        return '';
    }
}
