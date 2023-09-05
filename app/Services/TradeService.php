<?php

namespace App\Services;

use App\Exceptions\TradeFailException;
use App\Models\Trade;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class TradeService
{
    public static function getLastPairPrice(string $pair): float
    {
        $lastTrade = Trade::where('pair_traded', $pair)
            ->latest()
            ->first(['pair_traded_price']);
        return $lastTrade ? $lastTrade->pair_traded_price : 0;
    }

    public static function getLastValidBasePairPrice(string $pair): float
    {
        $lastTrade = Trade::where('pair_traded', $pair)
            ->latest()
            ->first(['base_pair_price']);
        return $lastTrade ? $lastTrade->base_pair_price : 0;
    }

    // TODO: Move to Exchange Service
    public static function getPairPrice(?string $pairSymbol = null): float
    {
        $pair = strtoupper($pairSymbol ?? SettingService::getValue('base_pair'));

        $cachedPrice = Cache::get('pair_price_' . $pair);
        if ($cachedPrice !== null) {
            return $cachedPrice;
        }

        try {
            $response = Http::get('https://api-cloud.bitmart.com/spot/v1/ticker_detail', [
                'symbol' => $pair
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $lastPrice = $data['data']['last_price'];

                // Cache the response for 4 minutes (240 seconds)
                $cacheDuration = SettingService::getInterval() - 30;

                Cache::put('pair_price_' . $pair, $lastPrice, $cacheDuration);

                return $lastPrice;
            }
        } catch (Exception $e) {
            // throw new TradeFailException('Unable to get price for '.$pair, $e);

            return self::getLastPairPrice($pair);
        }
    }

    public static function getPairPriceBySymbol(?string $pairSymbol = null): float
    {
        $symbol = strtoupper($pairSymbol ?? SettingService::getValue('base_pair'));
        return self::getPairPrice($symbol);
    }

    static function getTradeSize()
    {
        $size = SettingService::getValue('order_size');
        $percentage = SettingService::getValue('variation_percentage_range');

        $minValue = $size - ($size * $percentage / 100);
        $maxValue = $size + ($size * $percentage / 100);

        $minValue = max(1, $minValue);
        $maxValue = max(1, $maxValue);

        $randomValue = random_int($minValue, $maxValue);

        return $randomValue;
    }

    static private function getPrice($base_pair_percentage_change, $pair_to_trade_price): object
    {
        $ratio = SettingService::getValue('price_ratio');

        $percentageChange = $base_pair_percentage_change * $ratio;

        $newPrice = round($pair_to_trade_price * (1 + $percentageChange / 100), 8);

        return (object) [
            'price' => $newPrice,
            'percentage_change_used' => $percentageChange
        ];
    }

    static function getTradeData(): object
    {
        $pair_to_trade = SettingService::getValue('pair_to_trade');
        $pair_to_trade_price = TradeService::getPairPriceBySymbol($pair_to_trade);

        $base_pair_price = self::getPairPriceBySymbol();
        $base_pair_change = $base_pair_price - self::getLastValidBasePairPrice($pair_to_trade);

        $percentageChange = $base_pair_change / $base_pair_price * 100;

        $tradePrice = self::getPrice($percentageChange, $pair_to_trade_price);

        return (object) [
            'base_pair' => SettingService::getValue('base_pair'),
            'base_pair_price' => $base_pair_price,
            'base_pair_percentage_change' => $percentageChange,

            'pair_to_trade' => $pair_to_trade,
            'pair_to_trade_price' => $pair_to_trade_price,

            'trade_side' => mt_rand(0, 1) === 0 ? 'BUY' : 'SELL', // $diff >= 0 ? 'BUY' : 'SELL'
            'trade_size' => self::getTradeSize(),
            'trade_price' => $tradePrice->price,
            'percentage_change_used' => $tradePrice->percentage_change_used
        ];
    }
}
