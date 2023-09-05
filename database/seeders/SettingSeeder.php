<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'base_pair' => [
                'value' => 'XRP_USDT',
                'description' => 'The base pair to be used for change reference.',
            ],
            'pair_to_trade' => [
                'value' => 'UTED_USDT',
                'description' => 'The currency pair that will be traded. This represents the pair you want to buy and sell.',
            ],
            'order_size' => [
                'value' => 3800,
                'description' => 'The size of the BUY/SELL order to be placed. This represents the amount of the trading pair you want to buy or sell during each trade.',
            ],
            'trading_type' => [
                'value' => 'spot',
                'description' => 'The type of trading to be performed. Choose "spot" for spot trading or "futures" for futures trading.',
            ],
            'variation_percentage_range' => [
                'value' => 30,
                'description' => 'The percentage range within which the random order size will be generated for each trade.',
            ],
            'price_ratio' => [
                'value' => 0.1,
                'description' => 'The curresponding ration of Difference in Base Pair price to use',
            ],
            'operation_interval' => [
                'value' => 5,
                'description' => 'The time interval (in minutes) at which the bot will perform the trading operation.',
            ],
        ];

        foreach ($settings as $key => $data) {
            Setting::create([
                'name' => $key,
                'initial_value' => $data['value'],
                'current_value' => $data['value'],
                'description' => $data['description'],
            ]);
        }
    }
}
