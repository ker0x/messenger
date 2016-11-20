<?php
namespace Kerox\Messenger\Message\Attachment;

use Kerox\Messenger\Message\Attachment;

abstract class Template extends Attachment
{

    const TYPE_AIRLINE_BOARDINGPASS = 'airline_boardingpass';
    const TYPE_AIRLINE_CHECKIN = 'airline_checkin';
    const TYPE_AIRLINE_ITINERARY = 'airline_itinerary';
    const TYPE_AIRLINE_UPDATE = 'airline_update';
    const TYPE_BUTTON = 'button';
    const TYPE_GENERIC = 'generic';
    const TYPE_LIST = 'list';
    const TYPE_RECEIPT = 'receipt';

    public function __construct()
    {
        parent::__construct(Attachment::TYPE_TEMPLATE);
    }
}
