<x-filament-panels::page>
    <x-filament::card>
        <x-filament-tables::table :columns="$this->getTableColumns()" :records="$this->getTableData()" />
    </x-filament::card>

    @if (session()->has('message'))
        <div class="mt-4 text-green-600">
            {{ session('message') }}
        </div>
    @endif
</x-filament-panels::page>
