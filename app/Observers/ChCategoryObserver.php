<?php

namespace App\Observers;

use App\Models\User;
use App\Models\ChCategory;
use Filament\Notifications\Notification;

class ChCategoryObserver
{
    /**
     * Handle the ChCategory "created" event.
     */
    public function created(ChCategory $chCategory): void
    {
        $authUser = auth()->user()->name ?? 'auto update';
        Notification::make()
            ->title('"' .$chCategory->name . '": updated successfully.')
            ->success()
            ->body('User . ' . $authUser . ' updated category')
            ->sendToDatabase(User::all());
    }

    public function updating(ChCategory $chCategory)
    {
        // todo handle changes
        // dd($chCategory->getDirty());
        // todo add changes history
    }

    /**
     * Handle the ChCategory "updated" event.
     */
    public function updated(ChCategory $chCategory): void
    {
        $authUser = auth()->user()->name ?? 'auto update';
        Notification::make()
            ->title('"' .$chCategory->name . '": updated successfully.')
            ->success()
            ->body('User . ' . $authUser . ' updated category')
            ->sendToDatabase(User::all())
            ->send();
    }

    /**
     * Handle the ChCategory "deleted" event.
     */
    public function deleted(ChCategory $chCategory): void
    {
        //
    }

    /**
     * Handle the ChCategory "restored" event.
     */
    public function restored(ChCategory $chCategory): void
    {
        //
    }

    /**
     * Handle the ChCategory "force deleted" event.
     */
    public function forceDeleted(ChCategory $chCategory): void
    {
        //
    }
}
