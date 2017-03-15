<?php
namespace Kerox\Messenger\Api;

use GuzzleHttp\ClientInterface;
use Kerox\Messenger\Request\CodeRequest;
use Kerox\Messenger\Response\CodeResponse;

class Code extends AbstractApi
{

    const CODE_TYPE_STANDARD = 'standard';

    /**
     * @var null|\Kerox\Messenger\Api\Code
     */
    private static $_instance;

    /**
     * Code constructor.
     *
     * @param string $pageToken
     * @param \GuzzleHttp\ClientInterface $client
     */
    public function __construct(string $pageToken, ClientInterface $client)
    {
        parent::__construct($pageToken, $client);
    }

    /**
     * @param string $pageToken
     * @param \GuzzleHttp\ClientInterface $client
     * @return \Kerox\Messenger\Api\Code
     */
    public static function getInstance(string $pageToken, ClientInterface $client): Code
    {
        if (self::$_instance === null) {
            self::$_instance = new Code($pageToken, $client);
        }

        return self::$_instance;
    }

    /**
     * @param int $imageSize
     * @param string $codeType
     * @return CodeResponse
     */
    public function request(int $imageSize = 1000, string $codeType = self::CODE_TYPE_STANDARD): CodeResponse
    {
        $this->isValidCodeImageSize($imageSize);
        $this->isValidCodeType($codeType);

        $request = new CodeRequest($this->pageToken, $imageSize, $codeType);
        $response = $this->client->post('me/messenger_codes', $request->build());

        return new CodeResponse($response);
    }

    /**
     * @param int $imageSize
     * @throws \InvalidArgumentException
     */
    private function isValidCodeImageSize(int $imageSize)
    {
        if ($imageSize < 100 || $imageSize > 2000) {
            throw new \InvalidArgumentException('$imageSize must be between 100 and 2000');
        }
    }

    /**
     * @param string $codeType
     */
    private function isValidCodeType(string $codeType)
    {
        $allowedCodeType = $this->getAllowedCodeType();
        if (!in_array($codeType, $allowedCodeType)) {
            throw new \InvalidArgumentException('$codeType must be either ' . implode(', ', $allowedCodeType));
        }
    }

    /**
     * @return array
     */
    private function getAllowedCodeType(): array
    {
        return [
            self::CODE_TYPE_STANDARD,
        ];
    }
}
