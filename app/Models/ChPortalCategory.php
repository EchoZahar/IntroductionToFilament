<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChPortalCategory extends Model
{
    public $table = 'ch_portal_categories';

    protected $guarded = [];

    public function chCategory(): BelongsTo
    {
        return $this->belongsTo(ChCategory::class, 'ch_category_id');
    }
}
