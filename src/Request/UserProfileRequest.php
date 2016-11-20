<?php
namespace Kerox\Messenger\Request;

class UserProfileRequest extends AbstractRequest
{

    /**
     * @var array
     */
    protected $userProfileFields;

    public function __construct(string $pageToken, array $userProfileFields)
    {
        parent::__construct($pageToken);

        $this->userProfileFields = $userProfileFields;
    }

    /**
     * @return null
     */
    protected function buildHeaders()
    {
        return;
    }

    /**
     * @return null
     */
    protected function buildBody()
    {
        return;
    }

    /**
     * @return array
     */
    protected function buildQuery(): array
    {
        $fields = implode(',', $this->userProfileFields);

        $query = parent::buildQuery();
        $query += [
            'fields' => $fields
        ];

        return $query;
    }
}