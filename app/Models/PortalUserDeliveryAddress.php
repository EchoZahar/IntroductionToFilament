<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortalUserDeliveryAddress extends Model
{
    public $table = 'portal_user_delivery_addresses';

    protected $guarded = [];

    public function market(): BelongsTo
    {
        return $this->belongsTo(Market::class, 'market_id');
    }
}
