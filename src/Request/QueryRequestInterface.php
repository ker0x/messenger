<?php

declare(strict_types=1);

namespace Kerox\Messenger\Request;

interface QueryRequestInterface
{
    /**
     * @return string
     */
    public function buildQuery(): string;
}
