<?php

declare(strict_types=1);

namespace Kerox\Messenger\Response;

use Kerox\Messenger\Model\Persona;

class PersonaDataResponse extends AbstractResponse
{
    private const DATA = 'data';

    /**
     * @var Persona[]
     */
    protected $data = [];

    /**
     * @param array $response
     */
    protected function parseResponse(array $response): void
    {
        $this->setData($response);
    }

    /**
     * @return Persona[]
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $response
     */
    private function setData(array $response): void
    {
        if (isset($response[self::DATA]) && !empty($response[self::DATA])) {
            foreach ($response[self::DATA] as $data) {
                $this->data[] = Persona::create($data);
            }
        }
    }
}
