<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Market;
use Filament\Notifications\Notification;

class MarketObserver
{
    public function creating(Market $market): void
    {
        $this->setCreator($market);
    }

    public function created(Market $market): void
    {
        // todo: need to check credentials marketplace
        // todo: need check some credentials
        // todo: check portal hash
        // todo: return message - notification
    }

    public function updating(Market $market): void
    {
        $this->setEditor($market);
        // todo: need to check credentials marketplace
        // todo: need check some credentials
        // todo: check portal hash
    }

    public function updated(Market $market): void
    {
        Notification::make()
            ->title('"' . $market->name . '": updated successfully.')
            ->success()
            ->body('Changes to the market have been saved.')
            ->sendToDatabase(User::all());
    }

    public function deleted(Market $market): void
    {
        //
    }

    public function restored(Market $market): void
    {
        //
    }

    public function forceDeleted(Market $market): void
    {
        //
    }
    private function setCreator(Market $market)
    {
        $market->created_by = auth()->id();
    }

    private function setEditor(Market $market)
    {
        $market->modified_by = auth()->id();
    }
}
