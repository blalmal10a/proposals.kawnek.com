<?php

namespace App\Filament\Resources\FeatureGroups\Pages;

use App\Filament\Resources\FeatureGroups\FeatureGroupResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFeatureGroup extends ViewRecord
{
    protected static string $resource = FeatureGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
