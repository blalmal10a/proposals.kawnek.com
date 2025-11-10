<?php

namespace App\Filament\SelectFeature\Resources\Projects\Schemas;

use Filament\Forms\Components\Checkbox;
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
                    ->live()
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
                                    ->readOnly(),
                                Checkbox::make('is_selected')
                                    ->disabled(function ($record, $get, $set) {
                                        if ($record->is_required) return true;
                                        $feature_groups = $get('../../../../feature_groups');
                                        $featureList = [];
                                        foreach ($feature_groups as $groupKey => $feature_group) {
                                            foreach ($feature_group['features'] as $featureKey => $feature) {
                                                $featureList[$feature['uuid']] = [
                                                    'required_ids' => $feature['required_feature_ids'],
                                                    'is_selected' => $feature['is_selected'],
                                                ];
                                            }
                                        }
                                        $shouldDisable = ProjectForm::disable($record->required_feature_ids, $featureList);
                                        if ($shouldDisable) {
                                            $set('is_selected', false);
                                            return true;
                                        }
                                    })
                                    ->inline(false)

                            ])
                            ->columns(3)
                            ->columnSpanFull()
                    ])
                    ->columnSpanFull()
            ]);
    }

    public static function disable($required_feature_ids, $featureList = [])
    {
        // loop over the array of required feature UUIDs
        foreach ($required_feature_ids as $required_uuid) {
            // Check if the required feature exists in the featureList
            if (isset($featureList[$required_uuid])) {
                // Check if the required feature is NOT selected
                if (!$featureList[$required_uuid]['is_selected']) {

                    return true;
                }
            } else {
                // OPTIONAL: Depending on application logic, you might want to return true
                // or log an error if a required feature UUID is missing from the list.
                // For this implementation, we assume all required IDs are in featureList.
                // If you must handle missing IDs as a "not selected" case:
                // return true;
            }
        }

        // If the loop completes without finding any unselected required features, return false
        return false;
    }
}
