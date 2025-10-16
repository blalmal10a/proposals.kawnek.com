<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{
    use SoftDeletes;

    public function feature_group(): BelongsTo
    {
        return $this->belongsTo(FeatureGroup::class);
    }
}
