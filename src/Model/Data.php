<?php
namespace Kerox\Messenger\Model;

use Kerox\Messenger\Model\Data\Value;

class Data
{

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
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->data['name'] ?? '';
    }

    /**
     * @return string
     */
    public function getPeriod(): string
    {
        return $this->data['period'] ?? '';
    }

    /**
     * @return \Kerox\Messenger\Model\Data\Value[]
     */
    public function getValues(): array
    {
        $values = [];
        if (isset($this->data['values']) && !empty($this->data['values'])) {
            foreach ($this->data['values'] as $value) {
                $values[] = new Value($value['value'], $value['end_time']);
            }
        }

        return $values;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->data['title'] ?? '';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->data['description'] ?? '';
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->data['id'] ?? '';
    }
}
