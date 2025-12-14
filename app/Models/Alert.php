<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alert extends Model
{
  protected $fillable = [
    'product_id','store_id','price_entry_id','type','severity','message','meta'
  ];

  protected $casts = ['meta' => 'array'];

  public function product(): BelongsTo { return $this->belongsTo(Product::class); }
  public function store(): BelongsTo { return $this->belongsTo(Store::class); }
  public function priceEntry(): BelongsTo { return $this->belongsTo(PriceEntry::class); }
}
