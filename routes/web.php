<?php

use App\Models\EventUser;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/invite/{event_id}', function ($event_id) {
    if(!auth()->check()) {
        return redirect(filament()->getLoginUrl());
    }

    $event = \App\Models\Event::find($event_id);
    if (!$event) {
        return abort(404, 'Event not found');
    }

    EventUser::updateOrCreate([
        'event_id' => $event->id,
        'user_id' => auth()->user()->id,
    ], [
        'event_id' => $event->id,
        'user_id' => auth()->user()->id,
    ]);

    Notification::make()
        ->title('Invitation Accepted')
        ->body('You have successfully accepted the invitation to the event: ' . $event->name)
        ->success()
        ->send();

    return redirect()->route('filament.dashboard.resources.event-participants.view', ['record' => $event->id]);
})->name('invite');