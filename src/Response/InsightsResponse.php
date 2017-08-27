<?php

namespace Kerox\Messenger\Response;

use Kerox\Messenger\Model\Data;
use Psr\Http\Message\ResponseInterface;

class InsightsResponse extends AbstractResponse
{
    const DATA = 'data';

    /**
     * @var \Kerox\Messenger\Model\Data[]
     */
    protected $data = [];

    /**
     * InsightsResponse constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);
    }

    /**
     * @param array $response
     */
    protected function parseResponse(array $response)
    {
        $this->setData($response);
    }

    /**
     * @return \Kerox\Messenger\Model\Data[]
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $response
     */
    private function setData(array $response)
    {
        if (isset($response[self::DATA]) && !empty($response[self::DATA])) {
            foreach ($response[self::DATA] as $data) {
                $this->data[] = Data::create($data);
            }
        }
    }
}
