<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Project extends Model
{
    use SoftDeletes;

    public function getRouteKeyName()
    {
        return 'name_slug';
    }
    public function feature_groups(): HasMany
    {
        return $this->hasMany(FeatureGroup::class);
    }
}
