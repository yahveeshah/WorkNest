<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarouselSlide extends Model
{
    protected $fillable = ['organization_id', 'position', 'title', 'subtitle', 'description'];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
