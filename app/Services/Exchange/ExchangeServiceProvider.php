<?php

namespace App\Services\Exchange;

use App\Exceptions\TradeFailException;
use App\Models\Trade;
use App\Services\Exchange\ExchangeFactory;
use Illuminate\Support\Facades\Cache;

class ExchangeServiceProvider
{
    static public function handleTrade()
    {
        Cache::flush();

        $exchangeInstance = ExchangeFactory::create('bitmart');

        $order = $exchangeInstance->initOrder();

        if ( isset($order->order_data['order_id']) ) {

            Trade::create([
                'exchange_trade_id' => $order->order_data['order_id'],

                'base_pair' => $order->base_pair,
                'base_pair_price' => $order->base_pair_price,
                'base_pair_percentage_change' => $order->base_pair_percentage_change,

                'pair_traded' => $order->pair_to_trade,
                'pair_traded_price' => $order->pair_to_trade_price,

                'trade_side' => $order->trade_side,
                'trade_size' => $order->trade_size,
                'trade_price' => $order->trade_price,
                'percentage_change_used' => $order->percentage_change_used
            ]);

        } else {
            throw new TradeFailException('Failed Order', $order);
        }
    }
}
