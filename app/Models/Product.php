<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
  protected $fillable = ['name', 'slug', 'brand', 'sku'];

  public function priceEntries(): HasMany { return $this->hasMany(PriceEntry::class); }
  public function alerts(): HasMany { return $this->hasMany(Alert::class); }
}
