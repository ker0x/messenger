<?php
namespace Kerox\Messenger\Request;

class CodeRequest extends AbstractRequest
{

    /**
     * @var int
     */
    protected $imageSize;

    /**
     * @var string
     */
    protected $codeType;

    /**
     * CodeRequest constructor.
     *
     * @param string $pageToken
     * @param int $imageSize
     * @param string $codeType
     */
    public function __construct(string $pageToken, int $imageSize, string $codeType)
    {
        parent::__construct($pageToken);

        $this->imageSize = $imageSize;
        $this->codeType = $codeType;
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
            'type' => $this->codeType,
            'image_size' => $this->imageSize,
        ];

        return array_filter($body);
    }

    /**
     * @return array
     */
    protected function buildQuery(): array
    {
        return parent::buildQuery();
    }
}
