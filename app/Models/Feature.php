<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feature extends Model
{
    public function feature_group(): BelongsTo
    {
        return $this->belongsTo(FeatureGroup::class);
    }
}
