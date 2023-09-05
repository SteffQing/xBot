<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Trade;
use App\Services\SettingService;

class TradeTable extends DataTableComponent
{
    protected $model = Trade::class;

    public function builder(): Builder
    {
        // $base_pair = SettingService::getValue('base_pair');
        $pair_traded = SettingService::getValue('pair_to_trade');

        return Trade::
            // where('base_pair', $base_pair);
            where('pair_traded', $pair_traded);
    }

    public function configure(): void
    {
        $interval = SettingService::getInterval() + 30;

        $this
            ->setPrimaryKey('id')
            ->setColumnSelectStatus(false)
            ->setRefreshTime($interval)
            ->setRefreshVisible()
            ->setEmptyMessage('No recent trades')
            ->setDefaultSort('created_at', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("Order Id", "exchange_trade_id")
                ->collapseOnTablet()
                ->sortable(),

            Column::make("Price Before Trade", "pair_traded_price")
                ->collapseOnTablet()
                ->sortable(),

            Column::make("trade_size")
                ->sortable(),

            Column::make("trade_price")
                ->sortable(),

            Column::make("trade_side")
                ->sortable(),

            Column::make("base_pair")
                ->collapseOnTablet()
                ->sortable(),

            Column::make("base_pair_price")
                ->collapseOnTablet()
                ->sortable(),

            Column::make("base_pair_percentage_change")
                ->collapseOnTablet()
                ->sortable(),

            Column::make("percentage_change_used")
                ->collapseOnTablet()
                ->sortable(),

            Column::make("Created at", "created_at")
                ->collapseOnTablet()
                ->sortable()
        ];
    }
}
