<?php

declare(strict_types=1);

namespace Kerox\Messenger\Api;

use Kerox\Messenger\Model;
use Kerox\Messenger\Request\PersonaRequest;
use Kerox\Messenger\Response;
use Kerox\Messenger\SendInterface;

class Persona extends AbstractApi implements SendInterface
{
    /**
     * @param Model\Persona $persona
     *
     * @return Response\PersonaResponse
     */
    public function create(Model\Persona $persona): Response\PersonaResponse
    {
        $request = new PersonaRequest($this->pageToken, $persona);
        $response = $this->client->post('me/personas', $request->build());

        return new Response\PersonaResponse($response);
    }

    /**
     * @param int $personaId
     *
     * @return Response\PersonaResponse
     */
    public function getOne(int $personaId): Response\PersonaResponse
    {
        $request = new PersonaRequest($this->pageToken);
        $response = $this->client->get((string)$personaId, $request->build());

        return new Response\PersonaResponse($response);
    }

    /**
     * @return Response\PersonaDataResponse
     */
    public function getAll(): Response\PersonaDataResponse
    {
        $request = new PersonaRequest($this->pageToken);
        $response = $this->client->get('me/personas', $request->build());

        return new Response\PersonaDataResponse($response);
    }

    /**
     * @param int $personaId
     *
     * @return Response\PersonaResponse
     */
    public function delete(int $personaId): Response\PersonaResponse
    {
        $request = new PersonaRequest($this->pageToken);
        $response = $this->client->delete((string)$personaId, $request->build());

        return new Response\PersonaResponse($response);
    }
}
