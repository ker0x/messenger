<?php

namespace Kerox\Messenger\Request;

class UserRequest extends AbstractRequest
{
    /**
     * @var array
     */
    protected $fields;

    /**
     * UserRequest constructor.
     *
     * @param string $pageToken
     * @param array  $fields
     */
    public function __construct(string $pageToken, array $fields)
    {
        parent::__construct($pageToken);

        $this->fields = $fields;
    }

    protected function buildHeaders()
    {
    }

    protected function buildBody()
    {
    }

    /**
     * @return array
     */
    protected function buildQuery(): array
    {
        $fields = implode(',', $this->fields);

        $query = parent::buildQuery();
        $query += [
            'fields' => $fields,
        ];

        return $query;
    }
}
