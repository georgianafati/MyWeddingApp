<?php

namespace App\Filament\Resources\EventParticipantResource\Pages;

use App\Filament\Resources\EventParticipantResource;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\RepeatableEntry;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class ViewEventParticipant extends ViewRecord
{
    protected static string $resource = EventParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('pay')
                ->label('Pay')
                ->form(function(){
                    return [
                        TextInput::make('amount')
                            ->label('Amount')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(1000000)
                            ->placeholder('Enter amount to pay'),
                    ];
                })
                ->action(function($data, $record) {
                    try{
                        Stripe::setApiKey(config('app.STRIPE_SECRET_KEY'));

                        $session = Session::create([
                            'payment_method_types' => ['card'],
                            'line_items'  => [
                                [
                                    'price_data' => [
                                        'currency'     => 'eur',
                                        'product_data' => [
                                            'name' => "Payment for Event: " . $record->name,
                                        ],
                                        'unit_amount'  => $data['amount'] * 100,
                                    ],
                                    'quantity' => 1
                                ],
                            ],
                            'mode'        => 'payment',
                            'success_url' => route('stripe.success'). '?session_id={CHECKOUT_SESSION_ID}&event_id=' . $record->id,
                            'cancel_url'  => route('filament.dashboard.pages.dashboard'),
                        ]);

                        $payment = $record->transactions()->create([
                            'user_id' => auth()->user()->id,
                            'amount' => $data['amount'],
                            'stripe_status' => 'pending',
                            'stripe_id' => $session->id,
                        ]);

                        return redirect($session->url);
                    } catch(\Exception $e){
                        Notification::make()
                            ->title('Payment Error')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                })
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
            ])->columns([
                'sm' => 1,
                'lg' => 1,
            ])->extraAttributes([
                'class' => 'divide-y',
            ]);
    }
}
