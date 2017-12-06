<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment;

use Kerox\Messenger\Model\Message\Attachment;

abstract class Template extends Attachment
{
    protected const TYPE_AIRLINE_BOARDINGPASS = 'airline_boardingpass';
    protected const TYPE_AIRLINE_CHECKIN = 'airline_checkin';
    protected const TYPE_AIRLINE_ITINERARY = 'airline_itinerary';
    protected const TYPE_AIRLINE_UPDATE = 'airline_update';
    protected const TYPE_BUTTON = 'button';
    protected const TYPE_GENERIC = 'generic';
    protected const TYPE_LIST = 'list';
    protected const TYPE_RECEIPT = 'receipt';
    protected const TYPE_OPEN_GRAPH = 'open_graph';

    /**
     * Template constructor.
     */
    public function __construct()
    {
        parent::__construct(Attachment::TYPE_TEMPLATE);
    }
}
