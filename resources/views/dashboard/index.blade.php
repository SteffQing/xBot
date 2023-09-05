<x-app-layout>
    <div class="grid md:grid-cols-4 gap-6 mb-6">
        @include('dashboard.partials.stats')

        <div class="bg-white col-span-3 dark:bg-gray-800 p-6 rounded-lg">
            @include('dashboard.partials.settings')
        </div>
    </div>

    <!-- Table -->
    <h6 class="font-bold text-lg">Trades</h6>
    <livewire:trade-table />
</x-app-layout>
