<x-filament-panels::page>
        <div class="space-y-8">
            <!-- Backup Section -->
            <div class="p-4 bg-gray-800 rounded shadow">
                <h2 class="text-lg font-bold text-gray-100 mb-4">Backup Database</h2>
                <x-filament::button wire:click="backupDatabase" color="success">
                    Create Backup
                </x-filament::button>
            </div>
    
            <!-- Restore Section -->
            <div class="p-4 bg-gray-800 rounded shadow">
                <h2 class="text-lg font-bold text-gray-100 mb-4">Restore Database</h2>
                <form wire:submit.prevent="restoreDatabase">
                    <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4">
                        <x-filament::input type="file" wire:model="backupFile" class="text-gray-100" />
                        <x-filament::button type="submit" color="primary">
                            Restore
                        </x-filament::button>
                    </div>
                </form>
            </div>
    
            <!-- Display Backups -->
            <div class="p-4 bg-gray-800 rounded shadow">
                <h2 class="text-lg font-bold text-gray-100 mb-4">Existing Backups</h2>
                <table class="w-full text-left border border-gray-700">
                    <thead>
                        <tr class="bg-gray-700">
                            <th class="border border-gray-600 px-4 py-2 text-gray-300">File Name</th>
                            <th class="border border-gray-600 px-4 py-2 text-gray-300">Size</th>
                            <th class="border border-gray-600 px-4 py-2 text-gray-300">Last Modified</th>
                            <th class="border border-gray-600 px-4 py-2 text-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($this->backups as $backup)
                            <tr class="hover:bg-gray-700">
                                <td class="border border-gray-600 px-4 py-2 text-gray-100">{{ $backup['name'] }}</td>
                                <td class="border border-gray-600 px-4 py-2 text-gray-100">{{ number_format($backup['size'] / 1024, 2) }} KB</td>
                                <td class="border border-gray-600 px-4 py-2 text-gray-100">
                                    {{ \Carbon\Carbon::createFromTimestamp($backup['lastModified'])->diffForHumans() }}
                                </td>
                                <td class="border border-gray-600 px-4 py-2">
                                    <a href="{{ $backup['url'] }}" target="_blank" class="text-blue-400 hover:underline">Download</a>
                                    <x-filament::button wire:click="deleteBackup('{{ $backup['name'] }}')" color="danger" class="ml-2">
                                        Delete
                                    </x-filament::button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="border border-gray-600 px-4 py-2 text-center text-gray-400">
                                    No backups available.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    

</x-filament-panels::page>
