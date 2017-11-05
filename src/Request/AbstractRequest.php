<?php

namespace Kerox\Messenger\Request;

abstract class AbstractRequest
{
    /**
     * @var string
     */
    protected $pageToken;

    /**
     * AbstractRequest constructor.
     *
     * @param string $pageToken
     */
    public function __construct(string $pageToken)
    {
        $this->pageToken = $pageToken;
    }

    /**
     * @return mixed
     */
    abstract protected function buildHeaders();

    /**
     * @return mixed
     */
    abstract protected function buildBody();

    /**
     * @return array
     */
    protected function buildQuery(): array
    {
        return [
            'access_token' => $this->pageToken,
        ];
    }

    /**
     * @return array
     */
    public function build(): array
    {
        $request = [
            'headers' => $this->buildHeaders(),
            'json'    => $this->buildBody(),
            'query'   => $this->buildQuery(),
        ];

        return array_filter($request);
    }
}
