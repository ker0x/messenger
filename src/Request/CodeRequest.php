<?php

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
     * @var null|string
     */
    protected $ref;

    /**
     * CodeRequest constructor.
     *
     * @param string      $pageToken
     * @param int         $imageSize
     * @param string      $codeType
     * @param null|string $ref
     */
    public function __construct(string $pageToken, int $imageSize, string $codeType, $ref)
    {
        parent::__construct($pageToken);

        $this->imageSize = $imageSize;
        $this->codeType = $codeType;
        $this->ref = $ref;
    }

    /**
     * @return array
     */
    protected function buildHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * @return array
     */
    protected function buildBody(): array
    {
        $body = [
            'type'       => $this->codeType,
            'image_size' => $this->imageSize,
            'data'       => [
                'ref' => $this->ref,
            ]
        ];

        return $this->arrayFilter($body);
    }

    /**
     * @return array
     */
    protected function buildQuery(): array
    {
        return parent::buildQuery();
    }
}
