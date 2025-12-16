<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id
 * @property int $category_id
 * @property string $name_en
 * @property string $name_ku
 * @property string $description_en
 * @property string $description_ku
 * @property float $price
 * @property string|null $image_path
 * @property int $stock
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'name_en',
        'name_ku',
        'description_en',
        'description_ku',
        'price',
        'image_path',
        'stock',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the name attribute based on current locale
     */
    public function getNameAttribute(): string
    {
        $locale = app()->getLocale();
        return $this->{"name_{$locale}"} ?? $this->name_en;
    }

    /**
     * Get the description attribute based on current locale
     */
    public function getDescriptionAttribute(): string
    {
        $locale = app()->getLocale();
        return $this->{"description_{$locale}"} ?? $this->description_en;
    }

    /**
     * Get the product's category
     *
     * @return BelongsTo<Category, Product>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the product's order items
     *
     * @return HasMany<OrderItem>
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the product's cart items
     *
     * @return HasMany<CartItem>
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Scope a query to only include active products
     *
     * @param Builder<Product> $query
     * @return Builder<Product>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->where('stock', '>', 0);
    }

    /**
     * Scope a query to search products by name
     *
     * @param Builder<Product> $query
     */
    public function scopeSearch(Builder $query, ?string $search_term): Builder
    {
        if (!$search_term) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($search_term) {
            $q->where('name_en', 'LIKE', "%{$search_term}%")
              ->orWhere('name_ku', 'LIKE', "%{$search_term}%")
              ->orWhere('description_en', 'LIKE', "%{$search_term}%")
              ->orWhere('description_ku', 'LIKE', "%{$search_term}%");
        });
    }

    /**
     * Check if product is in stock
     */
    public function inStock(): bool
    {
        return $this->stock > 0 && $this->is_active;
    }

    /**
     * Get image URL or placeholder
     */
    public function getImageUrl(): string
    {
        $image_service = app(\App\Services\ImageService::class);
        return $image_service->url($this->image_path);
    }
}

