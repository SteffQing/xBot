<div class="flex justify-between items-center mb-2">
    <h6 class="font-bold text-lg">Settings</h6>
    <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'platform-settings-modal')">Edit Settings</x-primary-button>
</div>
<hr>

<div class="grid grid-cols-4 gap-6">
    @foreach ($settings as $name => $setting)
    <div>
        <p class="text-sm mt-5">{{ucwords( str_replace('_', ' ', $name) )}}</p>
        <p class="font-bold">{{$setting->value}}</p>
    </div>
    @endforeach
</div>

<x-modal name="platform-settings-modal" :show="$errors->settingsUpdate->isNotEmpty()" focusable>
    <form method="post" action="{{route('settings.update')}}" class="p-6">
        @csrf

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Platform Settings') }}
        </h2>

        <!-- base_pair Setting -->
        <div class="mt-6">
            <x-input-label for="base_pair" value="{{ __($settings['base_pair']->description) }}" />
            <x-text-input id="base_pair" name="base_pair" type="text" class="mt-1 block" placeholder="{{ __('Base Pair') }}" value="{{ $settings['base_pair']->value ?? old('base_pair') }}" />
            <x-input-error :messages="$errors->settingsUpdate->get('base_pair')" class="mt-2" />
        </div>

        <!-- pair_to_trade Setting -->
        <div class="mt-6">
            <x-input-label for="pair_to_trade" value="{{ __($settings['pair_to_trade']->description) }}" />
            <x-text-input id="pair_to_trade" name="pair_to_trade" type="text" class="mt-1 block" placeholder="{{ __('Pair to Trade') }}" value="{{ $settings['pair_to_trade']->value ?? old('pair_to_trade') }}" />
            <x-input-error :messages="$errors->settingsUpdate->get('pair_to_trade')" class="mt-2" />
        </div>

        <!-- order_size Setting -->
        <div class="mt-6">
            <x-input-label for="order_size" value="{{ __($settings['order_size']->description) }}" />
            <x-text-input type="number" id="order_size" name="order_size" class="mt-1 block" placeholder="{{ __('Order Size') }}" value="{{ $settings['order_size']->value ?? old('order_size') }}" />
            <x-input-error :messages="$errors->settingsUpdate->get('order_size')" class="mt-2" />
        </div>

        <!-- trading_type Setting -->
        <div class="mt-6">
            <x-input-label for="trading_type" value="{{ __($settings['trading_type']->description) }}" />
            <x-select-input id="trading_type" name="trading_type" class="mt-1 block" required readonly>
                @foreach(['spot', 'margin'] as $trading_type)
                <option value="{{ $trading_type }}" @if(old('trading_type')==$trading_type) selected @endif>{{ $trading_type }}</option>
                @endforeach
            </x-select-input>
            <x-input-error :messages="$errors->settingsUpdate->get('trading_type')" class="mt-2" />
        </div>

        <!-- variation_percentage_range Setting -->
        <div class="mt-6">
            <x-input-label for="variation_percentage_range" value="{{ __($settings['variation_percentage_range']->description) }}" />
            <x-text-input type="number" id="variation_percentage_range" min='1' max='100' name="variation_percentage_range" class="mt-1 block" placeholder="{{ __('Variation Percentage Range') }}" value="{{ $settings['variation_percentage_range']->value ?? old('variation_percentage_range') }}" />
            <x-input-error :messages="$errors->settingsUpdate->get('variation_percentage_range')" class="mt-2" />
        </div>

        <!-- price_ratio Setting -->
        <div class="mt-6">
            <x-input-label for="price_ratio" value="{{ __($settings['price_ratio']->description) }}" />
            <x-text-input type="number" id="price_ratio" name="price_ratio" min='0.01' step='0.01' class="mt-1 block" placeholder="{{ __('Price Ratio') }}" value="{{ $settings['price_ratio']->value ?? old('price_ratio') }}" />
            <x-input-error :messages="$errors->settingsUpdate->get('price_ratio')" class="mt-2" />
        </div>

        <!-- operation_interval Setting -->
        <div class="mt-6">
            <x-input-label for="operation_interval" value="{{ __($settings['operation_interval']->description) }}" />
            <x-text-input type="number" id="operation_interval" name="operation_interval" min='1' readonly class="mt-1 block" placeholder="{{ __('Operation Interval') }}" value="{{ $settings['operation_interval']->value ?? old('operation_interval') }}" />
            <x-input-error :messages="$errors->settingsUpdate->get('operation_interval')" class="mt-2" />
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3">
                {{ __('Update Settings') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>
