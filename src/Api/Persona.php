<?php

declare(strict_types=1);

namespace Kerox\Messenger\Api;

use GuzzleHttp\Exception\GuzzleException;
use Kerox\Messenger\Model;
use Kerox\Messenger\Request\PersonaRequest;
use Kerox\Messenger\Response;
use Kerox\Messenger\SendInterface;

class Persona extends AbstractApi implements SendInterface
{
    private const URI_PATH = 'me/personas';

    /**
     * @param string $name
     * @param string $profilePictureUrl
     *
     * @throws GuzzleException
     *
     * @return Response\PersonaResponse
     */
    public function create(string $name, string $profilePictureUrl): Response\PersonaResponse
    {
        $model = Model\Persona::create()
            ->setName($name)
            ->setProfilePictureUrl($profilePictureUrl);

        $request = new PersonaRequest($this->pageToken, $model);
        $response = $this->client->request('post', self::URI_PATH, $request->build());

        return new Response\PersonaResponse($response);
    }

    /**
     * @param string $personaId
     *
     * @throws GuzzleException
     *
     * @return Response\PersonaResponse
     */
    public function getOne(string $personaId): Response\PersonaResponse
    {
        $request = new PersonaRequest($this->pageToken);
        $response = $this->client->request('get', $personaId, $request->build());

        return new Response\PersonaResponse($response);
    }

    /**
     * @throws GuzzleException
     *
     * @return Response\PersonaDataResponse
     */
    public function getAll(): Response\PersonaDataResponse
    {
        $request = new PersonaRequest($this->pageToken);
        $response = $this->client->request('get', self::URI_PATH, $request->build());

        return new Response\PersonaDataResponse($response);
    }

    /**
     * @param string $personaId
     *
     * @throws GuzzleException
     *
     * @return Response\PersonaResponse
     */
    public function delete(string $personaId): Response\PersonaResponse
    {
        $request = new PersonaRequest($this->pageToken);
        $response = $this->client->request('delete', $personaId, $request->build());

        return new Response\PersonaResponse($response);
    }
}
