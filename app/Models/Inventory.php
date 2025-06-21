<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'category_id',
        'tags',
        'short_description',
        'full_description',
        'highlights',
        'price',
        'sale_price',
        'tax_percent',
        'offer_start_date',
        'offer_end_date',
        'stock_qty',
        'stock_status',
        'low_stock_alert',
        'barcode',
        'color_ids',
        'size_ids',
        'fabric',
        'fit',
        'pattern',
        'neck_style',
        'sleeve_type',
        'top_length',
        'weight',
        'length',
        'width',
        'height',
        'shipping_class',
        'returnable',
        'cod_available',
        'main_image',
        'gallery_images',
        'video_url',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'country_of_origin',
        'manufacturer',
        'hsn_code',
        'warranty',
        'care_instructions',
        'status',
        'visibility',
        'is_featured',
        'platform'
    ];

    protected $casts = [
        'color_ids' => 'array',
        'size_ids' => 'array',
        'gallery_images' => 'array',
        'returnable' => 'boolean',
        'cod_available' => 'boolean',
        'offer_start_date' => 'date',
        'offer_end_date' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
