<?php
namespace Kerox\Messenger\Response;

use Psr\Http\Message\ResponseInterface;

class ThreadResponse extends AbstractResponse
{

    const RESULT = 'result';

    /**
     * @var null|string
     */
    protected $result;

    /**
     * ThreadResponse constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);
    }

    /**
     * @param array $response
     * @return void
     */
    protected function parseResponse(array $response)
    {
        $this->setResult($response);
    }

    /**
     * @return null|string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param array $response
     */
    private function setResult(array $response)
    {
        if (isset($response[self::RESULT])) {
            $this->result = $response[self::RESULT];
        }
    }
}