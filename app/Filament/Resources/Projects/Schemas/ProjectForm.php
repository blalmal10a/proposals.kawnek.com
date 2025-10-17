<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;

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
                Repeater::make('feature_groups')
                    ->label('Features')
                    ->itemLabel(fn($state) => $state['title'])
                    ->relationship()
                    ->schema([
                        TextInput::make("title")->required(),
                        Repeater::make('features')
                            ->itemLabel(fn($state) => $state['name'])
                            ->relationship()
                            ->orderColumn('sort')
                            ->collapsed()
                            ->schema([
                                TextInput::make('name')
                                    ->required(),
                                Textarea::make('description'),
                                TextInput::make('cost')
                                    ->required()
                                    ->numeric(),
                                TextInput::make('yearly_cost'),
                                TextInput::make('monthly_cost'),
                                Grid::make()
                                    ->schema([
                                        Toggle::make('is_selected')
                                            ->inline(false),
                                        Toggle::make('is_required')
                                            ->inline(false),
                                    ])
                            ])
                            ->columnSpanFull()
                            ->columns(2)
                    ])
                    ->columnSpanFull()
                    ->collapsed()
                    ->orderColumn('sort')
                    ->live()
                    ->addActionAlignment(Alignment::Start)
            ]);
    }
}
