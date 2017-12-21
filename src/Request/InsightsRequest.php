<?php

declare(strict_types=1);

namespace Kerox\Messenger\Request;

class InsightsRequest extends AbstractRequest
{
    /**
     * @var array
     */
    protected $metrics;

    /**
     * UserRequest constructor.
     *
     * @param string $pageToken
     * @param array  $metrics
     */
    public function __construct(string $pageToken, array $metrics)
    {
        parent::__construct($pageToken);

        $this->metrics = $metrics;
    }

    protected function buildHeaders(): void
    {
    }

    protected function buildBody(): void
    {
    }

    /**
     * @return array
     */
    protected function buildQuery(): array
    {
        $metrics = implode(',', $this->metrics);

        $query = parent::buildQuery();
        $query += [
            'metric' => $metrics,
        ];

        return $query;
    }
}
