<?php

declare(strict_types=1);

namespace Kerox\Messenger\Api;

use Kerox\Messenger\Exception\InvalidKeyException;
use Kerox\Messenger\Exception\InvalidTypeException;
use Kerox\Messenger\NlpInterface;
use Kerox\Messenger\Request\NlpRequest;
use Kerox\Messenger\Response\NlpResponse;

class Nlp extends AbstractApi implements NlpInterface
{
    /**
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    public function config(array $configs = []): NlpResponse
    {
        $this->isValidConfigs($configs);

        $request = new NlpRequest($this->pageToken, $configs);
        $response = $this->client->post('me/nlp_configs', $request->build());

        return new NlpResponse($response);
    }

    /**
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    private function isValidConfigs(array $configs): void
    {
        $allowedConfigKeys = $this->getAllowedConfigKeys();
        if (!empty($configs)) {
            foreach ($configs as $key => $value) {
                if (!\in_array($key, $allowedConfigKeys, true)) {
                    throw new InvalidKeyException(sprintf('%s is not a valid key. configs must only contain "%s".', $key, implode(', ', $allowedConfigKeys)));
                }

                $this->isBool($key, $value);
                $this->isString($key, $value);
                $this->isValidNBest($key, $value);
            }
        }
    }

    /**
     * @param int|string $key
     * @param mixed      $value
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    private function isBool($key, $value): void
    {
        if (!\is_bool($value) &&
            \in_array($key, [self::CONFIG_KEY_NLP_ENABLED, self::CONFIG_KEY_VERBOSE], true)
        ) {
            throw new InvalidTypeException(sprintf('%s must be a boolean.', $key));
        }
    }

    /**
     * @param int|string $key
     * @param mixed      $value
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    private function isString($key, $value): void
    {
        if (!\is_string($value) &&
            \in_array($key, [self::CONFIG_KEY_CUSTOM_TOKEN, self::CONFIG_KEY_MODEL], true)
        ) {
            throw new InvalidTypeException(sprintf('%s must be a string.', $key));
        }
    }

    /**
     * @param int|string $key
     * @param mixed      $value
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    private function isValidNBest($key, $value): void
    {
        if ($key === self::CONFIG_KEY_N_BEST && (!\is_int($value) || $value < 1 || $value > 8)) {
            throw new InvalidTypeException(sprintf('%s must be an integer between 1 and 8.', $key));
        }
    }

    private function getAllowedConfigKeys(): array
    {
        return [
            self::CONFIG_KEY_NLP_ENABLED,
            self::CONFIG_KEY_MODEL,
            self::CONFIG_KEY_CUSTOM_TOKEN,
            self::CONFIG_KEY_VERBOSE,
            self::CONFIG_KEY_N_BEST,
        ];
    }
}
