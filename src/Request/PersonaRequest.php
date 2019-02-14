<?php

declare(strict_types=1);

namespace Kerox\Messenger\Request;

use Kerox\Messenger\Model\PersonaSettings;

class PersonaRequest extends AbstractRequest
{
    /**
     * @var \Kerox\Messenger\Model\PersonaSettings|null
     */
    protected $personaSettings;

    /**
     * ProfileRequest constructor.
     *
     * @param string                                      $pageToken
     * @param \Kerox\Messenger\Model\PersonaSettings|null $personaSettings
     */
    public function __construct(string $pageToken, PersonaSettings $personaSettings = null)
    {
        parent::__construct($pageToken);

        $this->personaSettings = $personaSettings;
    }

    /**
     * @return array|null
     */
    protected function buildHeaders(): ?array
    {
        $headers = [
            'Content-Type' => 'application/json',
        ];

        return $this->personaSettings instanceof PersonaSettings ? $headers : null;
    }

    /**
     * @return \Kerox\Messenger\Model\PersonaSettings|mixed|null
     */
    protected function buildBody()
    {
        if ($this->personaSettings instanceof PersonaSettings) {
            return $this->personaSettings;
        }
    }
}
