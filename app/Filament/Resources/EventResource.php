<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Actions\ActionGroup;
use Filament\Resources\RelationManagers\RelationGroup;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $label = 'My weddings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Details')
                    ->schema([
                        Hidden::make('user_id')
                            ->default(auth()->user()->id),
                        TextInput::make('name')
                            ->required()
                            ->label('Event Name')
                            ->placeholder('Enter event name'),
                        TextInput::make('location')
                            ->required()
                            ->label('Event Location')
                            ->placeholder('Enter event location'),
                        DateTimePicker::make('start_time')
                            ->required()
                            ->label('Event Start Time')
                            ->placeholder('Enter event start time')
                            ->seconds(false),
                        RichEditor::make('description')
                            ->required()
                            ->label('Event Description')
                            ->placeholder('Enter event description'),
                        RichEditor::make('menu')
                            ->label('Event Menu')
                            ->placeholder('Enter event menu')
                            ->columnSpanFull(),
                        RichEditor::make('music')
                            ->label('Event Music')
                            ->placeholder('Enter event music'),
                        FileUpload::make('location_image')
                            ->label('Location Image')
                            ->image()
                            ->columnSpanFull()
                            ->multiple(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->where('user_id', auth()->user()->id);
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
                    ->money('EUR', true)
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(fn (Event $record) => $record->getTotalBucketListsPriceAttribute()),
                Tables\Columns\TextColumn::make('Total Invitations')
                    ->label('Total Invitations')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(fn (Event $record) => $record->getTotalInvitationsAttribute()),
            ])->filters([
                //
            ])->headerActions([
                Tables\Actions\CreateAction::make(),
            ])->actions([
                //
            ])->bulkActions([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('invite_qr')
                        ->label('Invite with QR Code')
                        ->modal()
                        ->modalHeading('Invite with QR Code')
                        ->modalContent(function($record) {
                            return view('filament.event_qr_code', [
                                'event' => $record,
                            ]);
                        }),
                ]),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            RelationGroup::make('Gifts', [
                RelationManagers\TransactionsRelationManager::class,
            ]),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'view' => Pages\ViewEvent::route('/{record}'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
