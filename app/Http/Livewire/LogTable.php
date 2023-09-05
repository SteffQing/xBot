<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\FailLog;

class LogTable extends DataTableComponent
{
    protected $model = FailLog::class;

    public function configure(): void
    {
        $this
            ->setPrimaryKey('id')
            ->setColumnSelectStatus(false)
            ->setEmptyMessage('No recent fail logs')
            ->setDefaultSort('created_at', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),

            Column::make("exception_message")
                ->collapseOnTablet()
                ->sortable(),

            Column::make("exception_data")
                ->collapseOnTablet()
                ->sortable(),

            Column::make("Created at", "created_at")
                ->sortable(),
        ];
    }
}
