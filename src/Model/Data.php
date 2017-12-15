<?php

namespace Kerox\Messenger\Model;

use Kerox\Messenger\Model\Data\Value;

class Data
{
    /**
     * @var null|string
     */
    protected $name;

    /**
     * @var null|string
     */
    protected $period;

    /**
     * @var array
     */
    protected $values = [];

    /**
     * @var null|string
     */
    protected $title;

    /**
     * @var null|string
     */
    protected $description;

    /**
     * @var null|string
     */
    protected $id;

    /**
     * @var null|srting
     */
    protected $tag;

    /**
     * @var array
     */
    protected $data;

    /**
     * Data constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->name = $data['name'] ?? null;
        $this->period = $data['period'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->id = $data['id'] ?? null;
        $this->tag = $data['tag'] ?? null;

        $this->setValues($data);
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return null|string
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * @return \Kerox\Messenger\Model\Data\Value[]
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @param array $data
     *
     * @return \Kerox\Messenger\Model\Data
     */
    public function setValues(array $data): self
    {
        if (isset($data['values']) && !empty($data['values'])) {
            foreach ($data['values'] as $value) {
                $this->values[] = new Value($value['value'], $value['end_time']);
            }
        }

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return null|string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return null|string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @param array $data
     *
     * @return \Kerox\Messenger\Model\Data
     */
    public static function create(array $data): self
    {
        return new static($data);
    }
}
