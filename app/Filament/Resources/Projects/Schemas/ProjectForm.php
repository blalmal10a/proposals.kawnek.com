<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('client_name')
                    ->required(),
                RichEditor::make('description')
                    ->columnSpanFull(),
                DatePicker::make('initiated_at'),
                DatePicker::make('abandoned_at'),
            ]);
    }
}
