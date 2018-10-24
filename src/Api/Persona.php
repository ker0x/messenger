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
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Messenger\Response\PersonaResponse
     */
    public function add(PersonaSettings $persona): PersonaResponse
    {
        $request = new PersonaRequest('me/personas', $persona);
        $response = $this->client->sendRequest($request->build('post'));

        return new PersonaResponse($response);
    }

    /**
     * @param string $personaId
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Messenger\Response\PersonaResponse
     */
    public function get(string $personaId): PersonaResponse
    {
        $request = new PersonaRequest($personaId);
        $response = $this->client->sendRequest($request->build('get'));

        return new PersonaResponse($response);
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Messenger\Response\PersonaResponse
     */
    public function getAll(): PersonaResponse
    {
        $request = new PersonaRequest('me/personas');
        $response = $this->client->sendRequest($request->build('get'));

        return new PersonaResponse($response);
    }

    /**
     * @param string $personaId
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Messenger\Response\PersonaResponse
     */
    public function delete(string $personaId): PersonaResponse
    {
        $request = new PersonaRequest($personaId);
        $response = $this->client->sendRequest($request->build('delete'));

        return new PersonaResponse($response);
    }
}
