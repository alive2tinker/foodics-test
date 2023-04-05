<?php

namespace App\Observers;

use App\Jobs\NotifyOfLowStock;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Log;

class IngredientObserver
{
    /**
     * Handle the Ingredient "created" event.
     */
    public function created(Ingredient $ingredient): void
    {
        //
    }

    /**
     * Handle the Ingredient "updated" event.
     */
    public function updated(Ingredient $ingredient): void
    {
        if ($ingredient->wasChanged('topStock')) {
            if (!$ingredient->lowLevelNotification)
                $ingredient->update(['lowLevelNotification' => true]);
        } else if ($ingredient->wasChanged('currentStock')) {
            $stockPercentage = ((int) $ingredient->currentStock / (int) $ingredient->topStock) * 100;
            if ($stockPercentage <= 50 && $ingredient->lowLevelNotification) {
                NotifyOfLowStock::dispatch($ingredient);
                $dbIngredient = Ingredient::lockForUpdate()->find($ingredient->id);
                $dbIngredient->lowLevelNotification = false;
                $dbIngredient->save();
            }
        }
    }

    /**
     * Handle the Ingredient "deleted" event.
     */
    public function deleted(Ingredient $ingredient): void
    {
        //
    }

    /**
     * Handle the Ingredient "restored" event.
     */
    public function restored(Ingredient $ingredient): void
    {
        //
    }

    /**
     * Handle the Ingredient "force deleted" event.
     */
    public function forceDeleted(Ingredient $ingredient): void
    {
        //
    }
}
