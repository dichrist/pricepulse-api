<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PriceEntry extends Model
{
  protected $fillable = [
    'product_id','store_id','price_cents','currency','source','collected_at'
  ];

  protected $casts = ['collected_at' => 'datetime'];

  public function product(): BelongsTo { return $this->belongsTo(Product::class); }
  public function store(): BelongsTo { return $this->belongsTo(Store::class); }
}
