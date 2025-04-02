<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventParticipantResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\RelationManagers\RelationGroup;

class EventParticipantResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Invitations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->whereHas('users', function (Builder $query) {
                    $query->where('user_id', auth()->user()->id);
                });
            })
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Event Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Event Location')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_time')
                    ->label('Event Start Time')
                    ->dateTime()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('Total Bucket Lists Price')
                    ->label('Total Bucket Lists Price')
                    ->money('RON', true)
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(fn (Event $record) => $record->getTotalBucketListsPriceAttribute()),
                Tables\Columns\TextColumn::make('Total Invitations')
                    ->label('Total Invitations')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(fn (Event $record) => $record->getTotalInvitationsAttribute()),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
            ]);
    }

    public static function getRelations(): array
    {
            return [
                RelationGroup::make('Bucket list', [
                    RelationManagers\BucketListsRelationManager::class,
                ]),
                RelationGroup::make('Invitations', [
                    RelationManagers\UsersRelationManager::class,
                ]),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEventParticipants::route('/'),
            'view' => Pages\ViewEventParticipant::route('/{record}'),
        ];
    }
}
