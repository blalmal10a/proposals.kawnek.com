<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{
    use SoftDeletes;

    protected $casts = [
        'is_selected' => 'boolean',
        'is_requried' => 'boolean',
        'required_feature_ids' => 'array',
        'dependant_feature_ids' => 'array',
    ];

    public function feature_group(): BelongsTo
    {
        return $this->belongsTo(FeatureGroup::class);
    }
}
