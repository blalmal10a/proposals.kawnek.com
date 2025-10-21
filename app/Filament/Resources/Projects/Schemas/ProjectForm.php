<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Models\Feature;
use App\Models\Project;
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

                            KeyValue::make('feature_list')
                                ->dehydrated(false)
                                ->afterStateHydrated(function ($get, $set, $record) {
                                    $featureGroups = $record->feature_groups ?? [];
                                    $featureList = [];
                                    foreach ($featureGroups as $index => $featureGroup) {
                                        $features = $featureGroup['features'];
                                        foreach ($features as $featureIndex => $feature) {
                                            // logger($feature['uuid'] . ' - ' . $feature['name']);
                                            $featureList[$feature['uuid']] = $feature['name'] . " [" . $featureGroup['title'] . "]";
                                        }
                                    }
                                    $set('feature_list', $featureList);
                                })
                                ->live(),
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
                                                ->afterStateUpdated(function ($get, $state) {
                                                    $featureGroups = $get('../../../../feature_list');
                                                    $uuid = $get('uuid');
                                                    $featureGroups[$uuid] = $state;
                                                })
                                                ->live(onBlur: true)
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
                                                        logger($uid); // Optional logging
                                                        $set('uuid', $uid);
                                                    }
                                                }),
                                            Select::make('required_feature_ids')
                                                ->label(fn($get) => 'Required Feature for ' . $get('name'))
                                                ->multiple()
                                                ->options(function ($get) {
                                                    $featureList = $get('../../../../feature_list') ?? [];
                                                    return $featureList;
                                                })
                                            //
                                            ,
                                            Grid::make()
                                                ->schema([
                                                    Toggle::make('is_selected')
                                                        ->inline(false),
                                                    Toggle::make('is_required')
                                                        ->inline(false),

                                                ])
                                                ->afterStateHydrated(function ($get, $set) {
                                                    if (!$get('uuid')) {
                                                        $uid = (string) Str::uuid7();
                                                        logger('generate uuid is: ' . $uid);
                                                        $set('uuid', $uid);
                                                    }
                                                })
                                                ->live()
                                            //
                                            ,
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
                        ]),
                    //
                    // Step::make('Prject dependencies')
                    //     ->schema([
                    //         KeyValue::make('feature_list')
                    //             ->afterStateHydrated(function ($state) {
                    //                 logger('feature list is: ', $state);
                    //             })
                    //         //
                    //         ,
                    //         //
                    //         Repeater::make('feature_groups')
                    //             ->label('Features')
                    //             ->itemLabel(fn($state) => $state['title'])
                    //             ->relationship()
                    //             ->schema([
                    //                 Repeater::make('features')
                    //                     ->itemLabel(fn($state) => $state['name'])
                    //                     ->relationship()
                    //                     ->orderColumn('sort')
                    //                     ->schema([
                    //                         Select::make('required_feature_ids')
                    //                             ->label('Required Feature')
                    //                             ->multiple()
                    //                             ->searchable()
                    //                             ->options([])
                    //                             ->getSearchResultsUsing(function (string $search, $get, $livewire) {
                    //                                 $formData = $livewire->form->getState();
                    //                                 $featureList = $formData['feature_list'] ?? [];
                    //                                 return array_filter($featureList, function ($feature) use ($search) {
                    //                                     return str_contains(strtolower($feature), strtolower($search));
                    //                                 });
                    //                             })
                    //                             ->getOptionLabelUsing(function ($values) {
                    //                                 logger($values);
                    //                                 return [];
                    //                             })
                    //                         //
                    //                         ,
                    //                         Action::make('nothing')
                    //                             ->action(function ($get) {
                    //                                 logger($get('../../feature_list'));
                    //                             })

                    //                     ])
                    //                     ->columnSpan(3)
                    //                     ->columns(2)
                    //             ])
                    //             ->columns(4)
                    //             ->columnSpanFull()
                    //             // ->collapsed()
                    //             ->orderColumn('sort')
                    //             ->live()
                    //             ->addActionAlignment(Alignment::Start),

                    //     ])
                ])
                    ->columnSpanFull()
            ]);
    }
}
