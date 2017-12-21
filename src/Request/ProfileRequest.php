<?php

declare(strict_types=1);

namespace Kerox\Messenger\Request;

use Kerox\Messenger\Model\ProfileSettings;

class ProfileRequest extends AbstractRequest
{
    /**
     * @var mixed
     */
    protected $profileSettings;

    /**
     * ProfileRequest constructor.
     *
     * @param string $pageToken
     * @param mixed  $profileSettings
     */
    public function __construct(string $pageToken, $profileSettings)
    {
        parent::__construct($pageToken);

        $this->profileSettings = $profileSettings;
    }

    /**
     * @return null|array
     */
    protected function buildHeaders(): ?array
    {
        $headers = [
            'Content-Type' => 'application/json',
        ];

        return \is_string($this->profileSettings) ? null : $headers;
    }

    /**
     * @return null|array|\Kerox\Messenger\Model\ProfileSettings
     */
    protected function buildBody()
    {
        $body = null;
        if ($this->profileSettings instanceof ProfileSettings) {
            $body = $this->profileSettings;
        } elseif (\is_array($this->profileSettings)) {
            $body = [
                'fields' => $this->profileSettings,
            ];
        }

        return $body;
    }

    /**
     * @return array
     */
    protected function buildQuery(): array
    {
        $query = parent::buildQuery();

        if (\is_string($this->profileSettings)) {
            $query += [
                'fields' => $this->profileSettings,
            ];
        }

        return $query;
    }
}
