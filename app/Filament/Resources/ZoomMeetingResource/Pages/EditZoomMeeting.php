<?php

namespace App\Filament\Resources\ZoomMeetingResource\Pages;

use App\Filament\Resources\ZoomMeetingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditZoomMeeting extends EditRecord
{
    protected static string $resource = ZoomMeetingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
