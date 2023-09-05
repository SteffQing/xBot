<?php

namespace App\Services\Exchange\Providers;

use App\Exceptions\TradeFailException;
use App\Models\Setting;
use App\Services\Exchange\ExchangeInterface;
use App\Services\SettingService;
use App\Services\TradeService;
use Exception;
use Illuminate\Support\Facades\Http;

class Bitmart implements ExchangeInterface
{
    private $API_KEY = '7561692b0aa4c58fa28573a73700c51e54593af3';
    private $API_SECRET = '5f5355d3c90de4716fbb1dbeb2dbbfdd024433abc95f66baa2c6613c1492e6a9';
    private $API_MEMO = 'MMB';

    private $ORDER_URL = 'https://api-cloud.bitmart.com/spot/v2/submit_order';
    private $TYPE = 'limit';

    private $tradeData;

    function __construct()
    {
        $this->tradeData = TradeService::getTradeData();
    }

    private function get_timestamp()
    {
        return strval(round(microtime(true) * 1000));
    }

    private function generate_signature($timestamp, $body)
    {
        $message = $timestamp . '#' . $this->API_MEMO . '#' . json_encode($body);

        return hash_hmac('sha256', $message, $this->API_SECRET);
    }

    public function initOrder(): object
    {
        $timestamp = $this->get_timestamp();

        $body = [
            'size' => $this->tradeData->trade_size,
            'price' => $this->tradeData->trade_price,
            'side' => strtolower($this->tradeData->trade_side),
            'symbol' => $this->tradeData->pair_to_trade,
            'type' => $this->TYPE
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-BM-KEY' => $this->API_KEY,
                'X-BM-TIMESTAMP' => $timestamp,
                'X-BM-SIGN' => $this->generate_signature($timestamp, $body)
            ])->post($this->ORDER_URL, $body);

            $data = $response->json();

            return (object) array_merge((array) $this->tradeData, [
                'order_data' => $data['data'],
                'order_response' => $data['message']
            ]);
        } catch (Exception $e) {
            throw new TradeFailException($e, $body);
        }
    }
}
