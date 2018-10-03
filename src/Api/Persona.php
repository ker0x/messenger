<?php

declare(strict_types=1);

namespace Kerox\Messenger\Api;

use Kerox\Messenger\Model\PersonaSettings;
use Kerox\Messenger\Request\PersonaRequest;
use Kerox\Messenger\Response\PersonaResponse;

class Persona extends AbstractApi
{
    /**
     * @param \Kerox\Messenger\Model\PersonaSettings $persona
     *
     * @return \Kerox\Messenger\Response\PersonaResponse
     */
    public function add(PersonaSettings $persona): PersonaResponse
    {
        $request = new PersonaRequest($this->pageToken, $persona);
        $response = $this->client->post('me/personas', $request->build());

        return new PersonaResponse($response);
    }

    /**
     * @param string $personaId
     *
     * @return \Kerox\Messenger\Response\PersonaResponse
     */
    public function get(string $personaId): PersonaResponse
    {
        $request = new PersonaRequest($this->pageToken);
        $response = $this->client->get($personaId, $request->build());

        return new PersonaResponse($response);
    }

    /**
     * @return \Kerox\Messenger\Response\PersonaResponse
     */
    public function getAll(): PersonaResponse
    {
        $request = new PersonaRequest($this->pageToken);
        $response = $this->client->get('me/personas', $request->build());

        return new PersonaResponse($response);
    }

    /**
     * @param string $personaId
     *
     * @return \Kerox\Messenger\Response\PersonaResponse
     */
    public function delete(string $personaId): PersonaResponse
    {
        $request = new PersonaRequest($this->pageToken);
        $response = $this->client->delete($personaId, $request->build());

        return new PersonaResponse($response);
    }
}
