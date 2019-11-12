<?php

declare(strict_types=1);

namespace Kerox\Messenger\Request;

abstract class AbstractRequest
{
    /**
     * @var string
     */
    protected $pageToken;

    /**
     * AbstractRequest constructor.
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

    protected function buildQuery(): array
    {
        return [
            'access_token' => $this->pageToken,
        ];
    }

    public function build(): array
    {
        $request = [
            'headers' => $this->buildHeaders(),
            'json' => $this->buildBody(),
            'query' => $this->buildQuery(),
        ];

        return array_filter($request);
    }
}
