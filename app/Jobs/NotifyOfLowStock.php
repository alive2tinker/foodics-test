<?php

namespace App\Jobs;

use App\Mail\LowStockNotification;
use App\Models\Ingredient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyOfLowStock implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Ingredient $ingredient)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to('alsufiran@gmail.com')->send(new LowStockNotification($this->ingredient));
    }
}
