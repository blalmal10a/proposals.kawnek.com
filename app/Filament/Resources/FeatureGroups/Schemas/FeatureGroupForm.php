<?php

namespace App\Filament\Resources\FeatureGroups\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FeatureGroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('project_id')
                    ->relationship('project', 'name')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('sort')
                    ->required()
                    ->numeric(),
            ]);
    }
}
