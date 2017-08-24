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
        $this->setName($data)
            ->setPeriod($data)
            ->setValues($data)
            ->setTitle($data)
            ->setDescription($data)
            ->setId($data)
            ->setTag($data);
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param array $data
     * @return \Kerox\Messenger\Model\Data
     */
    public function setName(array $data): Data
    {
        if (isset($data['name'])) {
            $this->name = $data['name'];
        }

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * @param array $data
     * @return \Kerox\Messenger\Model\Data
     */
    public function setPeriod(array $data): Data
    {
        if (isset($data['period'])) {
            $this->period = $data['period'];
        }

        return $this;
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
     * @return \Kerox\Messenger\Model\Data
     */
    public function setValues(array $data): Data
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
     * @param array $data
     * @return \Kerox\Messenger\Model\Data
     */
    public function setTitle(array $data): Data
    {
        if (isset($data['title'])) {
            $this->title = $data['title'];
        }

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param array $data
     * @return \Kerox\Messenger\Model\Data
     */
    public function setDescription(array $data): Data
    {
        if (isset($data['description'])) {
            $this->description = $data['description'];
        }

        return $this;
    }

    /**
     * @return null|string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param array $data
     * @return \Kerox\Messenger\Model\Data
     */
    public function setId(array $data): Data
    {
        if (isset($data['id'])) {
            $this->id = $data['id'];
        }

        return $this;
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
     * @return \Kerox\Messenger\Model\Data
     */
    public function setTag(array $data): Data
    {
        if (isset($data['tag'])) {
            $this->tag = $data['tag'];
        }

        return $this;
    }

    /**
     * @param array $data
     * @return \Kerox\Messenger\Model\Data
     */
    public static function create(array $data): Data
    {
        return new static($data);
    }
}
