<?php

namespace App\Filament\Resources\EventParticipantResource\Pages;

use App\Filament\Resources\EventParticipantResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\RepeatableEntry;

class ViewEventParticipant extends ViewRecord
{
    protected static string $resource = EventParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('name')
                    ->label('Event Name'),
                TextEntry::make('description')
                    ->label('Event Description')
                    ->html(),
                TextEntry::make('location')
                    ->label('Event Location'),
                TextEntry::make('start_time')
                    ->label('Event Start Time'),
                ImageEntry::make('location_image')
                    ->label('Location Image'),
                TextEntry::make('menu')
                    ->label('Event Menu')
                    ->columnSpanFull()
                    ->html(),
                TextEntry::make('music')
                    ->label('Event Music')
                    ->html(),
            ]);
    }
}
