<?php

declare(strict_types=1);

namespace Kerox\Messenger\Request;

use Kerox\Messenger\Helper\UtilityTrait;
use Psr\Http\Message\RequestInterface;
use function GuzzleHttp\Psr7\stream_for;

class CodeRequest extends AbstractRequest implements BodyRequestInterface
{
    use UtilityTrait;

    /**
     * @var int
     */
    protected $imageSize;

    /**
     * @var string
     */
    protected $codeType;

    /**
     * @var null|string
     */
    protected $ref;

    /**
     * CodeRequest constructor.
     *
     * @param string      $path
     * @param int         $imageSize
     * @param string      $codeType
     * @param null|string $ref
     */
    public function __construct(string $path, int $imageSize, string $codeType, ?string $ref = null)
    {
        parent::__construct($path);

        $this->imageSize = $imageSize;
        $this->codeType = $codeType;
        $this->ref = $ref;
    }

    /**
     * @param string $method
     *
     * @return RequestInterface
     */
    public function build(string $method = 'post'): RequestInterface
    {
        return $this->origin
            ->withMethod($method)
            ->withBody(stream_for($this->buildBody()));
    }

    /**
     * @return string
     */
    public function buildBody(): string
    {
        $body = [
            'type' => $this->codeType,
            'image_size' => $this->imageSize,
            'data' => [
                'ref' => $this->ref,
            ],
        ];

        return \json_encode($this->arrayFilter($body));
    }
}
