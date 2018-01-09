<?php

declare(strict_types=1);

namespace Kerox\Messenger\Api;

use GuzzleHttp\ClientInterface;
use Kerox\Messenger\NlpInterface;
use Kerox\Messenger\Request\NlpRequest;
use Kerox\Messenger\Response\NlpResponse;

class Nlp extends AbstractApi implements NlpInterface
{
    /**
     * @var null|\Kerox\Messenger\Api\Nlp
     */
    private static $_instance;

    /**
     * @param string                      $pageToken
     * @param \GuzzleHttp\ClientInterface $client
     *
     * @return \Kerox\Messenger\Api\Nlp
     */
    public static function getInstance(string $pageToken, ClientInterface $client): self
    {
        if (self::$_instance === null) {
            self::$_instance = new self($pageToken, $client);
        }

        return self::$_instance;
    }

    /**
     * @param array $configs
     *
     * @throws \InvalidArgumentException
     *
     * @return \Kerox\Messenger\Response\NlpResponse
     */
    public function config(array $configs = []): NlpResponse
    {
        $this->isValidConfigs($configs);

        $request = new NlpRequest($this->pageToken, $configs);
        $response = $this->client->post('me/nlp_configs', $request->build());

        return new NlpResponse($response);
    }

    /**
     * @param array $configs
     *
     * @throws \InvalidArgumentException
     */
    private function isValidConfigs(array $configs): void
    {
        $allowedConfigKeys = $this->getAllowedConfigKeys();
        if (!empty($configs)) {
            foreach ($configs as $key => $value) {
                if (!\in_array($key, $allowedConfigKeys, true)) {
                    throw new \InvalidArgumentException($key . ' is not a valid key. $configs must only contain ' . implode(', ', $allowedConfigKeys));
                }

                $this->isBool($key, $value);
                $this->isString($key, $value);
                $this->isValidNBest($key, $value);
            }
        }
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @throws \InvalidArgumentException
     */
    private function isBool(string $key, $value): void
    {
        if (!\is_bool($value) && \in_array($key, [NlpInterface::CONFIG_KEY_NLP_ENABLED, NlpInterface::CONFIG_KEY_VERBOSE], true)) {
            throw new \InvalidArgumentException($key . ' must be a boolean');
        }
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @throws \InvalidArgumentException
     */
    private function isString(string $key, $value): void
    {
        if (!\is_string($value) && \in_array($key, [NlpInterface::CONFIG_KEY_CUSTOM_TOKEN, NlpInterface::CONFIG_KEY_MODEL], true)) {
            throw new \InvalidArgumentException($key . ' must be a string');
        }
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @throws \InvalidArgumentException
     */
    private function isValidNBest(string $key, $value): void
    {
        if ($key === NlpInterface::CONFIG_KEY_N_BEST && (!\is_int($value) || $value < 1 || $value > 8)) {
            throw new \InvalidArgumentException($key . ' must be an integer between 1 and 8');
        }
    }

    /**
     * @return array
     */
    private function getAllowedConfigKeys(): array
    {
        return [
            NlpInterface::CONFIG_KEY_NLP_ENABLED,
            NlpInterface::CONFIG_KEY_MODEL,
            NlpInterface::CONFIG_KEY_CUSTOM_TOKEN,
            NlpInterface::CONFIG_KEY_VERBOSE,
            NlpInterface::CONFIG_KEY_N_BEST,
        ];
    }
}
