<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name','slug','parent_id','category_type','is_active'];

    /* ---------- Relationships ---------- */
    // public function parent()   { return $this->belongsTo(self::class, 'parent_id'); }
    // public function children() { return $this->hasMany   (self::class, 'parent_id'); }

    /* ---------- Scopes ---------- */
    public function scopeMain   ($q) { return $q->where('category_type', 0); }
    public function scopeSub    ($q) { return $q->where('category_type', 1); }
    public function scopeSubSub ($q) { return $q->where('category_type', 2); }

    /* ---------- Accessors ---------- */
    public function getFullPathAttribute() : string
    {
        return $this->parent
            ? "{$this->parent->full_path} › {$this->name}"
            : $this->name;
    }

    /* ---------- Mutators ---------- */
    protected static function booted()
    {
        static::creating(function ($cat) {
            $cat->slug = Str::slug($cat->name);
        });
    }

    // Parent relationship (optional)
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // First-level children
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
