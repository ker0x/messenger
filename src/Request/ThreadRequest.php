<?php

declare(strict_types=1);

namespace Kerox\Messenger\Request;

use Kerox\Messenger\Model\ThreadControl;
use Psr\Http\Message\RequestInterface;
use function GuzzleHttp\Psr7\stream_for;

class ThreadRequest extends AbstractRequest implements BodyRequestInterface
{
    /**
     * @var \Kerox\Messenger\Model\ThreadControl
     */
    protected $threadControl;

    /**
     * TagRequest constructor.
     *
     * @param string        $path
     * @param ThreadControl $threadControl
     */
    public function __construct(string $path, ThreadControl $threadControl)
    {
        parent::__construct($path);

        $this->threadControl = $threadControl;
    }

    /**
     * @param string|null $method
     *
     * @return RequestInterface
     */
    public function build(?string $method = null): RequestInterface
    {
        return $this->origin
            ->withMethod('post')
            ->withBody(stream_for($this->buildBody()));
    }

    /**
     * @return string
     */
    public function buildBody(): string
    {
        return json_encode($this->threadControl);
    }
}
