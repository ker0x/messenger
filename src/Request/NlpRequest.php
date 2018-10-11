<?php

declare(strict_types=1);

namespace Kerox\Messenger\Request;

use GuzzleHttp\Psr7\Uri;
use Kerox\Messenger\Helper\UtilityTrait;
use Psr\Http\Message\RequestInterface;

class NlpRequest extends AbstractRequest implements QueryRequestInterface
{
    use UtilityTrait;

    /**
     * @var array
     */
    protected $configs;

    /**
     * CodeRequest constructor.
     *
     * @param string $path
     * @param array  $configs
     */
    public function __construct(string $path, array $configs)
    {
        parent::__construct($path);

        $this->configs = $configs;
    }

    /**
     * @param string|null $method
     *
     * @return RequestInterface
     */
    public function build(?string $method = null): RequestInterface
    {
        $uri = Uri::fromParts([
            'query' => $this->buildQuery(),
        ]);

        return $this->origin
            ->withMethod('post')
            ->withUri($uri);
    }

    /**
     * @return string
     */
    public function buildQuery(): string
    {
        $query = [
            'nlp_enabled' => $this->configs['nlp_enabled'] ?? null,
            'model' => $this->configs['model'] ?? null,
            'custom_token' => $this->configs['custom_token'] ?? null,
            'verbose' => $this->configs['verbose'] ?? null,
            'n_best' => $this->configs['n_best'] ?? null,
        ];

        return http_build_query($this->arrayFilter($query));
    }
}
