<?php

namespace App\Filament\Resources\FeatureGroups\Pages;

use App\Filament\Resources\FeatureGroups\FeatureGroupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFeatureGroups extends ListRecords
{
    protected static string $resource = FeatureGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
