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
    public static function canAccess(): bool
    {
        return false;
    }
}

