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
     * @param string                      $pageToken
     * @param \GuzzleHttp\ClientInterface $client
     */
    public function __construct(string $pageToken, ClientInterface $client)
    {
        parent::__construct($pageToken, $client);
    }

    /**
     * @param string                      $pageToken
     * @param \GuzzleHttp\ClientInterface $client
     *
     * @return \Kerox\Messenger\Api\Code
     */
    public static function getInstance(string $pageToken, ClientInterface $client): self
    {
        if (self::$_instance === null) {
            self::$_instance = new self($pageToken, $client);
        }

        return self::$_instance;
    }

    /**
     * @param int         $imageSize
     * @param string      $codeType
     * @param string|null $ref
     *
     * @return \Kerox\Messenger\Response\CodeResponse
     */
    public function request(int $imageSize = 1000, string $codeType = self::CODE_TYPE_STANDARD, string $ref = null): CodeResponse
    {
        $this->isValidCodeImageSize($imageSize);
        $this->isValidCodeType($codeType);

        if ($ref !== null) {
            $this->isValidRef($ref);
        }

        $request = new CodeRequest($this->pageToken, $imageSize, $codeType, $ref);
        $response = $this->client->post('me/messenger_codes', $request->build());

        return new CodeResponse($response);
    }

    /**
     * @param int $imageSize
     *
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
     *
     * @throws \InvalidArgumentException
     */
    private function isValidCodeType(string $codeType)
    {
        $allowedCodeType = $this->getAllowedCodeType();
        if (!in_array($codeType, $allowedCodeType, true)) {
            throw new \InvalidArgumentException('$codeType must be either ' . implode(', ', $allowedCodeType));
        }
    }

    /**
     * @param string $ref
     *
     * @throws \InvalidArgumentException
     */
    private function isValidRef(string $ref)
    {
        if (!preg_match('/^[a-zA-Z0-9\+\/=\-.:_ ]{1,250}$/', $ref)) {
            throw new \InvalidArgumentException('$ref must be a string of max 250 characters. Valid characters are a-z A-Z 0-9 +/=-.:_');
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
