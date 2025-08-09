<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ChCategory extends Model
{
    use SoftDeletes;

    public $table       = 'ch_categories';

    protected $guarded  = [];

    protected $casts    = [
        'portal_ids' => 'array'
    ];

    // public function portalCategory(): HasOne
    // {
    //     return $this->hasOne(ChPortalCategory::class, 'ch_category_id');
    // }
}
