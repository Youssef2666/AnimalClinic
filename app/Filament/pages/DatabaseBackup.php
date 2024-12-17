<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class DatabaseBackup extends Page
{
    use WithFileUploads;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    protected static string $view = 'filament.pages.database-backup';

    public static function canAccess(): bool
    {
        return Auth::user()->isAdmin();
    }


    public $backupFile;

    public function getBackupsProperty()
    {
        $backupFiles = Storage::files('backups');
        return collect($backupFiles)->map(function ($file) {
            return [
                'name' => basename($file),
                'size' => Storage::size($file),
                'lastModified' => Storage::lastModified($file),
                'url' => Storage::url($file),
            ];
        });
    }

    public function backupDatabase()
    {
        $fileName = 'backup-' . now()->format('Y-m-d_H-i-s') . '.sql';
        $path = storage_path('app/backups/' . $fileName);

        Storage::makeDirectory('backups');

        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s > %s',
            env('DB_USERNAME'),
            env('DB_PASSWORD'),
            env('DB_HOST', '127.0.0.1'),
            env('DB_DATABASE'),
            $path
        );

        exec($command, $output, $result);

        if ($result === 0) {
            session()->flash('success', 'Database backup created successfully!');
        } else {
            session()->flash('error', 'Failed to create database backup.');
        }
    }

    public function restoreDatabase()
    {
        if (!$this->backupFile) {
            session()->flash('error', 'من فضلك قم برفع ملف النسخة');
            return;
        }

        $filePath = $this->backupFile->store('backups');

        $command = sprintf(
            'mysql --user=%s --password=%s --host=%s %s < %s',
            env('DB_USERNAME'),
            env('DB_PASSWORD'),
            env('DB_HOST', '127.0.0.1'),
            env('DB_DATABASE'),
            storage_path('app/' . $filePath)
        );

        exec($command, $output, $result);

        if ($result === 0) {
            session()->flash('success', 'تم استعادة قاعدة البيانات بنجاح!');
        } else {
            session()->flash('error', 'فشل استعادة قاعدة البيانات.');
        }
    }

    public function deleteBackup($fileName)
    {
        Storage::delete('backups/' . $fileName);
        session()->flash('success', 'تم حذف النسخة بنجاح!');
    }
}
