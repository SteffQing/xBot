<?php

namespace App\Services\Exchange;

interface ExchangeInterface
{
    /**
     * Initiate Trade Order
     */
    public function initOrder(): object;
}
