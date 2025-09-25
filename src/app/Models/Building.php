<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OpenApi\Annotations as OA;

class Building extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'address',
        'longitude',
        'latitude',
    ];

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }
}
