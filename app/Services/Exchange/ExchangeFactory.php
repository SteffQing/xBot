<?php

namespace App\Services\Exchange;

use App\Exceptions\TradeFailException;
use App\Services\Exchange\Providers\Bitmart;

class ExchangeFactory
{
    protected static $exchangeClasses = [
        'bitmart' => Bitmart::class
    ];

    public static function create(string $exchange): ExchangeInterface
    {
        if (isset(self::$exchangeClasses[$exchange])) {

            $exchangeClass = self::$exchangeClasses[$exchange];

            return new $exchangeClass();
        }

        throw new TradeFailException('Invalid exchange code');
    }
}
