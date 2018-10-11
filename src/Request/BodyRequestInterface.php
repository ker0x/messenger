<?php

declare(strict_types=1);

namespace Kerox\Messenger\Request;

interface BodyRequestInterface
{
    /**
     * @return string
     */
    public function buildBody(): string;
}
