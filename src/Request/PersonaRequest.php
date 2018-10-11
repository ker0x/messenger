<?php

declare(strict_types=1);

namespace Kerox\Messenger\Request;

use Kerox\Messenger\Model\PersonaSettings;
use Psr\Http\Message\RequestInterface;
use function GuzzleHttp\Psr7\stream_for;

class PersonaRequest extends AbstractRequest implements BodyRequestInterface
{
    /**
     * @var PersonaSettings|null
     */
    protected $personaSettings;

    /**
     * ProfileRequest constructor.
     *
     * @param string               $path
     * @param PersonaSettings|null $personaSettings
     */
    public function __construct(string $path, PersonaSettings $personaSettings = null)
    {
        parent::__construct($path);

        $this->personaSettings = $personaSettings;
    }

    /**
     * @param string|null $method
     *
     * @return RequestInterface
     */
    public function build(?string $method = null): RequestInterface
    {
        $request = $this->origin->withMethod($method);
        $body = $this->buildBody();
        if (!empty($body)) {
            $request = $request->withBody(stream_for($this->buildBody()));
        }

        return $request;
    }

    /**
     * @return string
     */
    public function buildBody(): string
    {
        if ($this->personaSettings instanceof PersonaSettings) {
            return json_encode($this->personaSettings);
        }

        return '';
    }
}
