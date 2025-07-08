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
        'subcategory_id',
        'subsubcategory_id',
        'tags',
        'short_description',
        'full_description',
        'highlights',
        'fabric',
        'fit',
        'pattern',
        'neck_style',
        'sleeve_type',
        'top_length',
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
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'returnable' => 'boolean',
        'cod_available' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
