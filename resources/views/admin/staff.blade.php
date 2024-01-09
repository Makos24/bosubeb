<x-admin>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staff Data') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7/2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                @livewire('staff')

                <div class="p-6">
                    <livewire:staff-table class="bg-white-100" />
                </div>
            </div>
        </div>
    </div>
</x-admin>
