<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Filament\Tables\Actions\Action;

class BackupRestore extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.backup-restore';
    
    protected $backupDirectory = 'Aleef'; // Folder inside storage/app

    // Get backup files
    public function getBackups()
    {
        return collect(Storage::files('app/' . $this->backupDirectory))
            ->filter(function ($file) {
                return str_ends_with($file, '.zip');
            })
            ->map(function ($file) {
                return [
                    'name' => basename($file),
                    'path' => storage_path('app/' . $file), // Ensure it's a string path
                ];
            })
            ->toArray();
    }

    // Table columns
    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->label('Backup File Name'),
            Action::make('Restore')
                ->label('Restore')
                ->action(function ($record) {
                    $this->restoreBackup($record['path']);
                })
                ->color('primary')
                ->icon('heroicon-o-refresh'),
        ];
    }

    // Restore backup
    public function restoreBackup($backupFilePath)
    {
        if (file_exists($backupFilePath)) {
            Artisan::call('backup:restore', ['--path' => $backupFilePath]);
            session()->flash('message', 'Backup restored successfully.');
        } else {
            session()->flash('message', 'Backup file not found.');
        }
    }

    // Table data
    protected function getTableData(): array
    {
        return $this->getBackups();
    }
}

