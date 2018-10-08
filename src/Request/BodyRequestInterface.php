<?php

namespace Kerox\Messenger\Request;

interface BodyRequestInterface
{
    /**
     * @return string
     */
    public function buildBody(): string;
}
