<?php

declare(strict_types=1);

namespace Kerox\Messenger\Request;

use Kerox\Messenger\Helper\UtilityTrait;

class CodeRequest extends AbstractRequest
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
     * @var string|null
     */
    protected $ref;

    /**
     * CodeRequest constructor.
     */
    public function __construct(string $pageToken, int $imageSize, string $codeType, ?string $ref = null)
    {
        parent::__construct($pageToken);

        $this->imageSize = $imageSize;
        $this->codeType = $codeType;
        $this->ref = $ref;
    }

    protected function buildHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
        ];
    }

    protected function buildBody(): array
    {
        $body = [
            'type' => $this->codeType,
            'image_size' => $this->imageSize,
            'data' => [
                'ref' => $this->ref,
            ],
        ];

        return $this->arrayFilter($body);
    }
}
