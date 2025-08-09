<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardProductPricing extends Model
{
    public $table = 'card_product_pricing';

    public $guarded = [];

    public function cardProduct(): BelongsTo
    {
        return $this->belongsTo(CardProduct::class, 'card_product_id');
    }
}
