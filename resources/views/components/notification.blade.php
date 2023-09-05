@if (session('notify'))

@php
$notifyType = session('notify.type', 'success');
$iconName = ($notifyType === 'warning') ? 'exclamation' : (($notifyType === 'error') ? 'x-circle' : 'check');
@endphp

<div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="absolute top-3 md:top-10 right-3 md:right-10">
    <div role="alert" class="rounded-md border border-gray-100 bg-white p-4 shadow-xl">
        <div class="flex items-start gap-4">
            <span class="text-{{ $notifyType === 'warning' ? 'yellow' : ($notifyType === 'error' ? 'red' : 'green') }}-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                    @if ($notifyType === 'warning')
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M12 3a9 9 0 110 18 9 9 0 010-18z" />
                    @elseif ($notifyType === 'error')
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                    @else
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                    @endif
                </svg>
            </span>

            <div class="flex-1">
                @if (session('notify.header'))
                <strong class="block font-medium text-gray-900">{{ session('notify.header') }}</strong>
                @endif

                @if (session('notify.body'))
                <p class="mt-1 text-sm text-gray-700 max-w-[65vw] md:max-w-[40vw]">
                    {{ session('notify.body') }}
                </p>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
