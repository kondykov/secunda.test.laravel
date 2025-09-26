<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activity extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
        'is_category'
    ];

    protected $casts = [
        'level' => 'integer',
        'is_category' => 'boolean'
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Activity::class, 'parent_id');
    }

    public function scopeCategories($query)
    {
        return $query->where('is_category', true);
    }

    public function scopeActivities($query)
    {
        return $query->where('is_category', false);
    }

    public function scopeRootCategories($query)
    {
        return $query->whereNull('parent_id')->where('is_category', true);
    }

    protected static function booted()
    {
        /** @var Activity $activity */
        static::creating(function ($activity) {
            if ($activity->parent_id) {
                if ($activity->parent()?->parent()?->id) {
                    throw new \Exception('Достигнут максимальный уровень вложенности');
                }

                if (!$activity->is_category) {
                    $activity->is_category = false;
                }
            } else {
                $activity->is_category = $activity->is_category ?? true;
            }
        });
    }
}
