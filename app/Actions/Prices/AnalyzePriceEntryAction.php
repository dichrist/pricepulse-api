<?php 

namespace App\Actions\Prices;

use App\Models\Alert;
use App\Models\PriceEntry;

class AnalyzePriceEntryAction
{
  public function execute(PriceEntry $entry): void
  {
    $previous = PriceEntry::query()
      ->where('product_id', $entry->product_id)
      ->where('store_id', $entry->store_id)
      ->where('id', '<', $entry->id)
      ->orderByDesc('id')
      ->first();

    if (! $previous || $previous->price_cents <= 0) {
      return;
    }

    $delta = ($entry->price_cents - $previous->price_cents) / $previous->price_cents;
    $abs = abs($delta);
    
    if ($abs < 0.40) {
      return;
    }

    $type = $delta < 0 ? 'PRICE_DROP' : 'PRICE_SPIKE';
    $severity = $abs >= 0.60 ? 'HIGH' : 'MEDIUM';

    Alert::create([
      'product_id' => $entry->product_id,
      'store_id' => $entry->store_id,
      'price_entry_id' => $entry->id,
      'type' => $type,
      'severity' => $severity,
      'message' => $delta < 0
        ? 'Possible anomaly: price dropped sharply'
        : 'Possible anomaly: price increased sharply',
      'meta' => [
        'previous_price_cents' => $previous->price_cents,
        'new_price_cents' => $entry->price_cents,
        'delta_percent' => round($delta * 100, 2),
      ],
    ]);
  }
}
