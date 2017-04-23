<?php

namespace Kerox\Messenger\Model\Callback;

class Referral
{

    /**
     * @var mixed
     */
    protected $ref;

    /**
     * @var string
     */
    protected $source;

    /**
     * @var string
     */
    protected $type;

    /**
     * Referral constructor.
     *
     * @param $ref
     * @param string $source
     * @param string $type
     */
    public function __construct($ref, string $source, string $type)
    {
        $this->ref = $ref;
        $this->source = $source;
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param array $payload
     * @return \Kerox\Messenger\Model\Callback\Referral
     */
    public static function create(array $payload): Referral
    {
        return new static($payload['ref'], $payload['source'], $payload['type']);
    }
}
