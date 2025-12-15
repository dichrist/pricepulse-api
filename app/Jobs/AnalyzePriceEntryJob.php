<?php

namespace App\Jobs;

use App\Actions\Prices\AnalyzePriceEntryAction;
use App\Models\PriceEntry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AnalyzePriceEntryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $priceEntryId) {}

    public function handle(AnalyzePriceEntryAction $action): void
    {
        $entry = PriceEntry::find($this->priceEntryId);
        if (! $entry) return;

        $action->execute($entry);
    }
}
