<?php

namespace App\Filament\Resources\Features\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FeatureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Select::make('feature_group_id')
                    ->relationship('feature_group', 'title')
                    ->required(),
                Toggle::make('is_selected')
                    ->required(),
                Toggle::make('default_selection_value'),
                Toggle::make('is_required')
                    ->required(),
                TextInput::make('required_feature_ids'),
                TextInput::make('dependant_feature_ids'),
                TextInput::make('cost')
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('yearly_cost')
                    ->numeric(),
                TextInput::make('monthly_cost')
                    ->numeric(),
            ]);
    }
}
