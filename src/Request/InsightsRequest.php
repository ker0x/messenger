<?php

declare(strict_types=1);

namespace Kerox\Messenger\Request;

use Kerox\Messenger\Helper\UtilityTrait;

class InsightsRequest extends AbstractRequest
{
    use UtilityTrait;

    /**
     * @var array
     */
    protected $metrics;

    /**
     * @var int|null
     */
    protected $since;

    /**
     * @var int|null
     */
    protected $until;

    /**
     * UserRequest constructor.
     *
     * @param string   $pageToken
     * @param array    $metrics
     * @param int|null $since
     * @param int|null $until
     */
    public function __construct(string $pageToken, array $metrics, ?int $since = null, ?int $until = null)
    {
        parent::__construct($pageToken);

        $this->metrics = $metrics;
        $this->since = $since;
        $this->until = $until;
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
            'since' => $this->since,
            'until' => $this->until,
        ];

        return $this->arrayFilter($query);
    }
}
