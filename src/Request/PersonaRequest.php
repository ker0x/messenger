<?php

namespace Kerox\Messenger\Request;

use Kerox\Messenger\Model\Persona;

class PersonaRequest extends AbstractRequest
{
    /**
     * @var Persona|null
     */
    protected $persona;

    /**
     * PersonaRequest constructor.
     *
     * @param string       $pageToken
     * @param Persona|null $persona
     */
    public function __construct(string $pageToken, ?Persona $persona = null)
    {
        parent::__construct($pageToken);

        $this->persona = $persona;
    }

    /**
     * @return mixed
     */
    protected function buildHeaders()
    {
        return [
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * @return mixed
     */
    protected function buildBody()
    {
        return $this->persona ?: '';
    }
}
