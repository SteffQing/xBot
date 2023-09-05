@php
$statItems = [
['stat' => $stats->base_price, 'label' => __('Base Pair Price at Last Trade')],
['stat' => $stats->trading_pair_price, 'label' => __('Trading Pair Price')],
];
@endphp

<!-- Stats -->
<div class="space-y-6">
    @foreach ($statItems as $item)
    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 md:p-6">
        <h3 class="text-2xl md:text-4xl mb-1">{{ $item['stat'] }}</h3>
        <p class="text-sm">{{ $item['label'] }}</p>
    </div>
    @endforeach
</div>
