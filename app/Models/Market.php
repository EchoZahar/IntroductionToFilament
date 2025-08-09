<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Market extends Model
{
    use SoftDeletes;

    public $table = 'markets';

    protected $guarded = [];

    protected $casts = [
        'credentials'   => 'array', //'json:unicode',
        'contacts'      => 'array', //'json:unicode',
        'is_active'     => 'boolean', //'boolean'
    ];


    public function marketplace(): BelongsTo
    {
        return $this->belongsTo(Marketplace::class, 'marketplace_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'modified_by');
    }

    public function portalAgreements(): HasMany
    {
        return $this->hasMany(PortalUserAgreement::class, 'market_id');
    }

    public function portalWarehouses(): HasMany
    {
        return $this->hasMany(PortalWarehouse::class, 'market_id');
    }

    public function portalDeliveryTypes(): HasMany
    {
        return $this->hasMany(PortalDeliveryType::class, 'market_id');
    }

    public function portalDeliveryAddresses(): HasMany
    {
        return $this->hasMany(PortalUserDeliveryAddress::class, 'market_id');
    }
}
