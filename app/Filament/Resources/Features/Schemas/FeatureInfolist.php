<?php

namespace App\Filament\Resources\Features\Schemas;

use App\Models\Feature;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class FeatureInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('feature_group.title')
                    ->label('Feature group'),
                IconEntry::make('is_selected')
                    ->boolean(),
                IconEntry::make('default_selection_value')
                    ->boolean()
                    ->placeholder('-'),
                IconEntry::make('is_required')
                    ->boolean(),
                TextEntry::make('cost')
                    ->money()
                    ->placeholder('-'),
                TextEntry::make('yearly_cost')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('monthly_cost')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Feature $record): bool => $record->trashed()),
            ]);
    }
}
