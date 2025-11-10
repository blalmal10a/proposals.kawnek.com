<?php

namespace App\Filament\SelectFeature\Resources\Projects\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('summary')
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        RichEditor::make('description')
                            ->disabled()
                            ->columnSpanFull(),
                        // TextInput::make('client_name')
                        //     ->required(),
                        // DatePicker::make('initiated_at'),
                        // DatePicker::make('abandoned_at'),
                    ])
                    ->columnSpanFull(),
                Repeater::make('feature_groups')
                    ->label('Features')
                    ->relationship()
                    ->schema([
                        Repeater::make('features')
                            ->label(function ($record) {
                                return $record->title;
                            })
                            ->relationship()
                            ->schema([
                                TextInput::make('name')
                                    ->readOnly(),

                                TextInput::make('cost')
                                    ->hidden(function ($record) {
                                        return !$record->cost;
                                    })
                                    ->readOnly(),
                                TextInput::make('yearly_cost')
                                    ->hidden(function ($record) {
                                        return !$record->yearly_cost;
                                    })
                                    ->readOnly()
                            ])
                            ->columns(2)
                            ->columnSpanFull()
                    ])
                    ->columnSpanFull()
            ]);
    }
}
