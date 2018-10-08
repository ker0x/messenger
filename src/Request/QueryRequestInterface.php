<?php

namespace Kerox\Messenger\Request;

interface QueryRequestInterface
{
    /**
     * @return string
     */
    public function buildQuery(): string;
}
