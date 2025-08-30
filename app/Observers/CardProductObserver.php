<?php

namespace App\Observers;

use App\Models\User;
use App\Models\CardProduct;
use Filament\Notifications\Notification;
use App\Services\CardProduct\Update\CheckCardProduct;
use Illuminate\Support\Facades\Auth;

class CardProductObserver
{
    public function creating(CardProduct $cardProduct): void
    {

    }

    public function created(CardProduct $cardProduct): void
    {
        $this->setCreator($cardProduct);
        Notification::make()
            ->title('Created new card')
            ->success()
            ->body('"' . $cardProduct->unique_key . '": created successfully.')
            ->sendToDatabase(User::all());
    }

    public function updating(CardProduct $cardProduct): void
    {
        Notification::make()
            ->title('Updated card ' . $cardProduct->unique_key)
            ->success()
            ->body('"' . $cardProduct->unique_key . '": updated successfully.')
            ->send();
        $this->check($cardProduct);
    }

    /**
     * Handle the CardProduct "updated" event.
     */
    public function updated(CardProduct $cardProduct): void
    {
        $this->setEditor($cardProduct);
        $user = $this->defineUser();
        // todo get status before send notifications (generate message)
        Notification::make()
            ->title('Updated card ' . $cardProduct->unique_key)
            ->success()
            ->body($user->name . ' updated card: \"{$cardProduct->unique_key}\"')
            ->sendToDatabase(User::all());
    }

    /**
     * Handle the CardProduct "deleted" event.
     */
    public function deleted(CardProduct $cardProduct): void
    {
        $this->setEditor($cardProduct);
        $user = $this->defineUser();
        Notification::make()
            ->title('Deleted card ' . $cardProduct->unique_key)
            ->warning()
            ->body( $user->name . "successfully delete card: \"{$cardProduct->unique_key}\"")
            ->sendToDatabase(User::all());
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

    public function setEditor(CardProduct $c): void
    {
        $c->modified_by = auth()->id() ?? null;
    }

    public function setCreator(CardProduct $c): void
    {
        $c->created_by = auth()->id() ?? null;
    }

    public function check(CardProduct $card): void
    {
        (new CheckCardProduct())->handle($card);
    }

    private function defineUser()
    {
        return Auth::user();
    }
}
