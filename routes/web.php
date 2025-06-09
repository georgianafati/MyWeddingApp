<?php

use App\Models\EventUser;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Route;
use Stripe\Stripe;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;

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


Route::get('/stripe-success', function(Request $request) {
    if(isset($request->session_id)){
        Stripe::setApiKey(config('app.STRIPE_SECRET_KEY'));

        try{
            $session = Session::retrieve($request->session_id);

            $transaction = \App\Models\EventTransaction::where('stripe_id', $session->id)->where('event_id', $request->event_id)->where('stripe_status', 'pending')->first();

            if($session && $session['payment_status'] == 'paid' && $transaction){
                $transaction->update([
                    'stripe_status' => 'paid',
                    'stripe_id' => $session['payment_intent'],
                ]);

                Notification::make()
                    ->title('Payment Successful')
                    ->body('Your payment for the event has been successfully processed.')
                    ->success()
                    ->send();
            }
        } catch(\Exception $e){
            return redirect()->route('stripe.error')->with('errors', $e->getMessage());
        }
    }

    return view('payments.success')->with('success', 'Payment successful. Credits added to your account.');

})->name('stripe.success');

Route::get('/stripe-error', function() {
    return view('payments.error');
})->name('stripe.error');
