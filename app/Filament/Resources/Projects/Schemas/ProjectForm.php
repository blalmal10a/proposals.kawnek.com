<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Illuminate\Support\Str;

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
                            // ->default([])
                            ->itemLabel(fn($state) => $state['name'])
                            ->relationship()
                            ->orderColumn('sort')
                            // ->collapsed()
                            ->schema([
                                TextInput::make('name')
                                    ->required(),
                                Textarea::make('description'),
                                TextInput::make('cost')
                                    ->required(function ($state, $get) {
                                        return !$get('yearly_cost') && !$get('monthly_cost');
                                    })
                                    ->numeric(),
                                TextInput::make('yearly_cost'),
                                TextInput::make('monthly_cost'),
                                Hidden::make('uuid')
                                    ->dehydrated(true)
                                    ->afterStateHydrated(function ($state, $set) {
                                        if (!$state) {
                                            $uid = (string) Str::uuid7();
                                            $set('uuid', $uid);
                                        }
                                    }),
                                Grid::make()
                                    ->schema([
                                        Toggle::make('is_selected')
                                            ->inline(false),
                                        Toggle::make('is_required')
                                            ->inline(false),
                                    ]),
                                Action::make('hehe')
                                    ->action(function ($get, $set, $state) {
                                        // logger($get('../../feature_groups'));
                                        $featureGroups = $get('../../feature_groups');
                                        foreach ($featureGroups as $index => $featureGroup) {
                                            // logger($featureGroup['features']);
                                            $features = $featureGroup['features'];
                                            foreach ($features as $featureIndex => $feature) {
                                                logger($feature);
                                            }
                                        }
                                    })
                            ])
                            ->columnSpan(3)
                            ->columns(2)
                    ])
                    ->columns(4)
                    ->columnSpanFull()
                    // ->collapsed()
                    ->orderColumn('sort')
                    ->live()
                    ->addActionAlignment(Alignment::Start)
            ]);
    }
}
