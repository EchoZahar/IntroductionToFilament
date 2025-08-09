<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Marketplace extends Model
{
    use SoftDeletes;

    public $table = 'marketplaces';

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function markets(): HasMany
    {
        return $this->hasMany(Market::class, 'marketplace_id');
    }
}
