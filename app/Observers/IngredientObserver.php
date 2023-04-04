<?php

namespace App\Observers;

use App\Jobs\NotifyOfLowStock;
use App\Models\Ingredient;

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
        switch ($ingredient->wasChanged()){
            case 'topStock':
                if(!$ingredient->lowLevelNotification)
                    $ingredient->update(['lowLevelNotification' => true]);
                break;
            case 'currentStock':
                $stockPercentage = ($ingredient->currentStock / $ingredient->topStock) * 100;
                if($stockPercentage < 50 && $ingredient->lowLevelNotification){
                    $ingredient->update(['lowLevelNotification' => false]);
                    NotifyOfLowStock::dispatch($ingredient);
                }
                break;
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
