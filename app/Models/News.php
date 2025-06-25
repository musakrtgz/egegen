<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'slug',
        'image',
        'is_active',
        'published_at',
    ];

    protected $casts = [
        'image' => 'string',
        'is_active' => 'boolean',
        'published_at' => 'datetime:Y-m-d H:i:s',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Model'in boot metodu
     */
    protected static function boot()
    {
        parent::boot();

        // yeni kayıt ekleme sırasında slug ve yayınlanma tarihi boş ise oluştur
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title) . '-' . Str::random(4);
            }
            if (empty($model->published_at)) {
                //$model->published_at = now();
            }
        });
    }

    /**
     * Aktif haberleri filtrelemek için scope
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Yayınlanmış haberleri filtrelemek için scope
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }
}
