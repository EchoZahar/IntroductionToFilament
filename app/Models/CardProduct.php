<?php

namespace App\Models;

use App\Enum\CardProduct\CardStatusEnum;
use App\Enum\CardProduct\MultiplicityEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property integer $portal_nomenclature_id
 * @property integer $ch_category_id
 * @property string $name
 * @property string $description
 * @property string $brand
 * @property string $article
 * @property string $unique_key
 * @property string $barcode
 * @property string $multiplicity
 * @property integer $multiplicity_sale
 * @property string $tnved
 * @property string $okpd2
 * @property string $combine
 * @property string $group
 * @property array $errors_or_exceptions
 * @property integer $created_by
 * @property integer $modified_by
 */
class CardProduct extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    public $table = 'card_products';

    protected $guarded = [];

    protected $casts = [
        'multiplicity'  => MultiplicityEnum::class,
        'status'        => CardStatusEnum::class,
        'errors_or_exceptions' => 'array',
    ];

    public function registerMediaConversions(?Media $media = null): void
    {
        // Конвертация full HD 1920 * 1080
        $kb = round(($media->size / 1024), 2);
        if ($kb > 1024) {
            $this->addMediaConversion('hd')
                ->optimize()
                ->queued();
        } else {
            $this->addMediaConversion('hd')->nonQueued();
        }
        // миниатюра 250 * 250
        $this->addMediaConversion('thumb')
            ->width(250)
            ->height(250)
            ->queued();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ChCategory::class, 'ch_category_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'modified_by');
    }

    public function dimension(): HasOne
    {
        return $this->hasOne(CardProductDimension::class, 'card_product_id');
    }

    public function pricing(): HasOne
    {
        return $this->hasOne(CardProductPricing::class, 'card_product_id');
    }
}
