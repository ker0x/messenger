<?php

declare(strict_types=1);

namespace Kerox\Messenger\Request;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;

class UserRequest extends AbstractRequest implements QueryRequestInterface
{
    /**
     * @var array
     */
    protected $fields;

    /**
     * UserRequest constructor.
     *
     * @param string $path
     * @param array  $fields
     */
    public function __construct(string $path, array $fields)
    {
        parent::__construct($path);

        $this->fields = $fields;
    }

    /**
     * @param string|null $method
     *
     * @return RequestInterface
     */
    public function build(?string $method = null): RequestInterface
    {
        return $this->origin
            ->withUri(Uri::fromParts(['query' => $this->buildQuery()]));
    }

    /**
     * @return string
     */
    public function buildQuery(): string
    {
        $fields = implode(',', $this->fields);

        $query = [
            'fields' => $fields,
        ];

        return http_build_query($query);
    }
}
