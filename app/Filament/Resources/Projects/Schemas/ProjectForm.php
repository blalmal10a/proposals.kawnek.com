<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {

        return $schema
            ->components([
                Wizard::make([
                    Step::make('Project feature')
                        ->schema([
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
                                        ->schema([
                                            TextInput::make('name')
                                                ->afterStateUpdated(function ($get) {
                                                    $featureGroups = $get('../../feature_groups');
                                                    logger($featureGroups);
                                                })
                                                ->afterStateHydrated(function ($get) {
                                                    $featureGroups = $get('../../feature_groups');
                                                })
                                                ->required(),
                                            Textarea::make('description'),
                                            TextInput::make('cost')
                                                ->required(function ($state, $get) {
                                                    return !$get('yearly_cost') && !$get('monthly_cost');
                                                })
                                                ->numeric(),
                                            Toggle::make('is_recurring')
                                                ->dehydrated(false)
                                                ->inline(false)
                                                ->default(false),
                                            Grid::make()
                                                ->columnSpanFull()
                                                ->schema([
                                                    TextInput::make('yearly_cost'),
                                                    TextInput::make('monthly_cost'),
                                                ])
                                                ->hidden(fn($get) => !$get('is_recurring'))
                                            //
                                            ,
                                            Hidden::make('uuid')
                                                ->dehydrated(true)
                                                ->afterStateHydrated(function ($state, $set) {
                                                    if (!$state) {
                                                        $uid = (string) Str::uuid7();
                                                        $set('uuid', $uid);
                                                    }
                                                }),
                                            // Select::make('required_feature_ids')

                                            //     ->preload(false)
                                            // //
                                            // ,
                                            Grid::make()
                                                ->schema([
                                                    Toggle::make('is_selected')
                                                        ->inline(false),
                                                    Toggle::make('is_required')
                                                        ->inline(false),
                                                ]),
                                            // Action::make('hehe')
                                            //     ->action(function ($get, $set, $state) {
                                            //         // logger($get('../../feature_groups'));
                                            //         $featureGroups = $get('../../feature_groups');
                                            //         foreach ($featureGroups as $index => $featureGroup) {
                                            //             // logger($featureGroup['features']);
                                            //             $features = $featureGroup['features'];
                                            //             foreach ($features as $featureIndex => $feature) {
                                            //                 logger($feature['uuid'] . ' - ' . $feature['name']);
                                            //             }
                                            //         }
                                            //     })
                                        ])
                                        ->columnSpan(3)
                                        ->columns(2)
                                ])
                                ->columns(4)
                                ->columnSpanFull()
                                // ->collapsed()
                                ->orderColumn('sort')
                                ->live()
                                ->addActionAlignment(Alignment::Start),
                            KeyValue::make('feature_list')

                                ->afterStateHydrated(function ($get, $set) {
                                    $featureGroups = $get('feature_groups');
                                    $featureList = [];
                                    foreach ($featureGroups as $index => $featureGroup) {
                                        $features = $featureGroup['features'];
                                        foreach ($features as $featureIndex => $feature) {
                                            // logger($feature['uuid'] . ' - ' . $feature['name']);
                                            $featureList[$feature['uuid']] = $feature['name'];
                                        }
                                    }
                                    $set('feature_list', $featureList);
                                })
                        ]),
                    //
                    Step::make('Prject dependencies')
                        ->schema([
                            //
                            Repeater::make('feature_groups')
                                ->label('Features')
                                ->itemLabel(fn($state) => $state['title'])
                                ->relationship()
                                ->schema([
                                    Repeater::make('features')
                                        ->itemLabel(fn($state) => $state['name'])
                                        ->relationship()
                                        ->orderColumn('sort')
                                        ->schema([
                                            CheckboxList::make('required_feature_ids')
                                                ->options(function ($get, $livewire) {

                                                    $formData = $livewire->form->getState();
                                                    logger($formData);
                                                    return [];
                                                })
                                            //     ->options([
                                            //         function ($livewire) {
                                            //             $formData = $livewire->form->getState();
                                            //             logger($formData);
                                            //             return [];
                                            //         }
                                            //     ]),
                                        ])
                                        ->columnSpan(3)
                                        ->columns(2)
                                ])
                                ->columns(4)
                                ->columnSpanFull()
                                // ->collapsed()
                                ->orderColumn('sort')
                                ->live()
                                ->addActionAlignment(Alignment::Start),

                        ])
                ])
                    ->columnSpanFull()
            ]);
    }
}
