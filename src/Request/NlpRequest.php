<?php

declare(strict_types=1);

namespace Kerox\Messenger\Request;

use Kerox\Messenger\Helper\UtilityTrait;

class NlpRequest extends AbstractRequest
{
    use UtilityTrait;

    /**
     * @var array
     */
    protected $configs;

    /**
     * CodeRequest constructor.
     */
    public function __construct(string $pageToken, array $configs)
    {
        parent::__construct($pageToken);

        $this->configs = $configs;
    }

    protected function buildHeaders(): void
    {
    }

    protected function buildBody(): void
    {
    }

    protected function buildQuery(): array
    {
        $query = parent::buildQuery();
        $query += [
            'nlp_enabled' => $this->configs['nlp_enabled'] ?? null,
            'model' => $this->configs['model'] ?? null,
            'custom_token' => $this->configs['custom_token'] ?? null,
            'verbose' => $this->configs['verbose'] ?? null,
            'n_best' => $this->configs['n_best'] ?? null,
        ];

        return $this->arrayFilter($query);
    }
}
