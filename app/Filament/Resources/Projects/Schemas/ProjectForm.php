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
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
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
                Grid::make()
                    ->schema([
                        Section::make('summary')
                            ->schema([
                                TextInput::make('name')
                                    ->required(),
                                TextInput::make('client_name')
                                    ->required(),
                                RichEditor::make('description')
                                    ->columnSpanFull(),
                                DatePicker::make('initiated_at'),
                                DatePicker::make('abandoned_at'),

                                Text::make(function ($get) {
                                    $feature_groups = $get('feature_groups');
                                    $amount = ProjectForm::calculateTotalCost($feature_groups);
                                    return "TOTAL AMOUNT: ₹" . number_format($amount, 2);
                                }),
                                KeyValue::make('feature_list')
                                    ->hidden()
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
                            ]),
                        Section::make('Features')
                            ->schema([

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
                                                            ->afterStateUpdated(function ($state, $set) {
                                                                if ($state) {
                                                                    $set('is_selected', $state);
                                                                }
                                                            })
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

    public static function calculateTotalCost($feature_groups)
    {
        $total = 0;
        foreach ($feature_groups as $groupKey => $feature_group) {
            foreach ($feature_group['features'] as $featureKey => $feature) {
                if ($feature['is_selected'])
                    $total += $feature['cost'];
            }
        }
        return $total;
    }
}
