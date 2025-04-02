<?php

namespace App\Filament\Resources\EventParticipantResource\Pages;

use App\Filament\Resources\EventParticipantResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEventParticipants extends ListRecords
{
    protected static string $resource = EventParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
