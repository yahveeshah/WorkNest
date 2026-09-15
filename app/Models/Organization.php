<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

class Organization extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];

    /**
     * Get the users associated with the organization.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function carouselSlides(): HasMany
    {
        return $this->hasMany(CarouselSlide::class)->orderBy('position');
    }
}
