<?php

namespace App\Filament\Resources\FeatureGroups\Schemas;

use App\Models\FeatureGroup;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class FeatureGroupInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('project.name')
                    ->label('Project'),
                TextEntry::make('title'),
                TextEntry::make('sort')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (FeatureGroup $record): bool => $record->trashed()),
            ]);
    }
}
