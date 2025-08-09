<?php

namespace App\Observers;

use App\Models\User;
use App\Models\CardProduct;
use Filament\Notifications\Notification;

class CardProductObserver
{
    public function creating(CardProduct $cardProduct): void
    {

    }

    public function created(CardProduct $cardProduct): void
    {
        Notification::make()
            ->title('Created new card')
            ->success()
            ->body('"' . $cardProduct->unique_key . '": created successfully.')
            ->sendToDatabase(User::all());
    }

    public function updating(CardProduct $cardProduct): void
    {
        // dd(session(), request()->user(), request()->path());
        Notification::make()
            ->title('Updated card ' . $cardProduct->unique_key)
            ->success()
            ->body('"' . $cardProduct->unique_key . '": updated successfully.')
            ->sendToDatabase(User::all());
    }

    /**
     * Handle the CardProduct "updated" event.
     */
    public function updated(CardProduct $cardProduct): void
    {
        // todo get status before send notifications (generate message)
        Notification::make()
            ->title('Updated card ' . $cardProduct->unique_key)
            ->success()
            ->body('"' . $cardProduct->unique_key . '": updated successfully.')
            ->sendToDatabase(User::all());
    }

    /**
     * Handle the CardProduct "deleted" event.
     */
    public function deleted(CardProduct $cardProduct): void
    {
        //
    }

    /**
     * Handle the CardProduct "restored" event.
     */
    public function restored(CardProduct $cardProduct): void
    {
        //
    }

    /**
     * Handle the CardProduct "force deleted" event.
     */
    public function forceDeleted(CardProduct $cardProduct): void
    {
        //
    }
}
