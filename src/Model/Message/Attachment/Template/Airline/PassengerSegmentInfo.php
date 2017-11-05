<?php

namespace Kerox\Messenger\Model\Message\Attachment\Template\Airline;

use Kerox\Messenger\Helper\ValidatorTrait;

class PassengerSegmentInfo implements \JsonSerializable
{
    use ValidatorTrait;

    /**
     * @var string
     */
    protected $segmentId;

    /**
     * @var string
     */
    protected $passengerId;

    /**
     * @var string
     */
    protected $seat;

    /**
     * @var string
     */
    protected $seatType;

    /**
     * @var array
     */
    protected $productInfo = [];

    /**
     * PassengerSegmentInfo constructor.
     *
     * @param string $segmentId
     * @param string $passengerId
     * @param string $seat
     * @param string $seatType
     */
    public function __construct(string $segmentId, string $passengerId, string $seat, string $seatType)
    {
        $this->segmentId = $segmentId;
        $this->passengerId = $passengerId;
        $this->seat = $seat;
        $this->seatType = $seatType;
    }

    /**
     * @param string $title
     * @param string $value
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Airline\PassengerSegmentInfo
     *
     * @internal param array $productInfo
     */
    public function addProductInfo(string $title, string $value): self
    {
        $this->isValidArray($this->productInfo, 4);

        $this->productInfo[] = [
            'title' => $title,
            'value' => $value,
        ];

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = [
            'segment_id'   => $this->segmentId,
            'passenger_id' => $this->passengerId,
            'seat'         => $this->seat,
            'seat_type'    => $this->seatType,
            'product_info' => $this->productInfo,
        ];

        return array_filter($json);
    }
}
